<?php

namespace app\modules\job\controllers\frontend;

use Yii;
use app\components\FrontendController;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;

use app\modules\job\models\User;
use app\modules\job\models\UserJob;

class AccountController extends FrontendController {

    private $_encryptKey = 'mv6ncFCqh8';

    private function _encrypt($data)
    {
        return base64_encode(Yii::$app->security->encryptByKey(json_encode($data), $this->_encryptKey));
    }

    private function _decrypt($data)
    {
        return json_decode(Yii::$app->getSecurity()->decryptByKey(base64_decode($data), $this->_encryptKey), true);
    }

    public function beforeAction($action)
    {
        // check logined & role

        return parent::beforeAction($action);
    }

    public function actions() {
        return [
            'oauth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
                'successUrl' => Url::to(['success', 'role' => Yii::$app->request->getQueryParam('role')])
            ],
        ];
    }

    public function successCallback($client)
    {
        $attributes = $client->getUserAttributes();

        $authProvider = Yii::$app->request->getQueryParam('authclient');
        $authUid = (isset($attributes['id'])) ? $attributes['id'] : '';
        $authName = (isset($attributes['name'])) ? $attributes['name'] : '';
        $authEmail = (isset($attributes['email'])) ? $attributes['email'] : '';

        if ($authProvider == 'google') {
            if (isset($attributes['displayName'])) {
                $authName = $attributes['displayName'];
            }
            if (isset($attributes['emails'][0]['value'])) {
                $authEmail = $attributes['emails'][0]['value'];
            }
        }

        Yii::$app->session->set('user.auth', [
            'provider' => $authProvider,
            'uid' => $authUid,
            'name' => $authName,
            'email' => $authEmail
        ]);
    }

    public function actionSuccess()
    {
        /* @var $user \app\modules\job\models\User */

        $auth = Yii::$app->session->get('user.auth');
        Yii::$app->session->remove('user.auth');

        $role = Yii::$app->request->getQueryParam('role', UserJob::$roleDefault);
        if (!in_array($role, UserJob::$roleAllows)) {
            $role = UserJob::$roleDefault;
        }

        if (empty($auth)) {
            return $this->goHome();
        }

        $user = User::findByOpenId($auth['uid'], $auth['provider']);
        if ($user !== null) {
            Yii::$app->user->login($user);

            $modelJob = UserJob::find()->where(['_id' => Yii::$app->user->id, 'role' => $role])->one();
            if ($modelJob != null) {
                Yii::$app->session->set('jobAccountRole', $modelJob->role);
                return $this->redirect(["/job/{$modelJob->role}/index"]);
            }
        }

        // Đăng ký account
        return $this->redirect(['register', 'oauth' => $this->_encrypt($auth), 'role' => $role]);
    }

    public function actionLogout() {
        Yii::$app->user->logout();

        $role = Yii::$app->request->getQueryParam('role', UserJob::$roleDefault);
        if (!in_array($role, UserJob::$roleAllows)) {
            $role = UserJob::$roleDefault;
        }

        return $this->redirect(['login', 'role' => $role]);
    }

    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $role = Yii::$app->request->getQueryParam('role', UserJob::$roleDefault);
        if (!in_array($role, UserJob::$roleAllows)) {
            $role = UserJob::$roleDefault;
        }

        $model = new User();
        $model->scenario = 'login';

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // Function User::login() khong xu ly role nen lam them buoc nay de kiem tra role
            $modelJob = UserJob::find()->where(['_id' => Yii::$app->user->id, 'role' => $role])->one();
            if ($modelJob != null) {
                Yii::$app->session->set('jobAccountRole', $modelJob->role);
                return $this->redirect(["/job/{$modelJob->role}/index"]);
            }

            // Neu kiem tra role khong hop le thi logout roi yeu cau login lai
            Yii::$app->getSession()->setFlash('flash', [
                'type' => 'error',
                'title' => Yii::t('account', 'Login Error'),
                'message' => Yii::t('account', 'You are not allowed to access this page.'),
                'duration' => 10000
            ]);
            return $this->redirect(['/job/account/logout', 'role' => $role]);
        }

        Yii::$app->view->title = Yii::t($this->module->id, 'Sign in');
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        return $this->render('login', [
            'model' => $model,
            'role' => $role
        ]);
    }

    public function actionRegister() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $role = Yii::$app->request->getQueryParam('role', UserJob::$roleDefault);
        if (!in_array($role, UserJob::$roleAllows)) {
            $role = UserJob::$roleDefault;
        }

        $model = new User();
        $model->scenario = "register_{$role}";
        $jobModel = new UserJob();
        $jobModel->scenario = "register_{$role}";
        $jobModel->role = $role;
        $jobModel->setDefaultValues();

        $oauth = false;
        $oauthData = [];

        if (($oauthParam = Yii::$app->request->getQueryParam('oauth')) != null) {
            if (($oauthData = $this->_decrypt($oauthParam)) != null) {
                $oauth = true;
                if ($model->email === null)
                    $model->email = $oauthData['email'];
            }
        }

        if ($model->load(Yii::$app->request->post()) && $jobModel->load(Yii::$app->request->post())) {
            $modelValidate = $model->validate();
            $jobModelValidate = $jobModel->validate();

            if ($modelValidate && $jobModelValidate) {
                $model->status = User::STATUS_ACTIVE;
                $jobModel->email = $model->email;

                if ($oauth === true && !empty($oauthData)) {
                    $model->openids = [$oauthData['provider'] => $oauthData['uid']];
                }

                if ($model->save(false)) {
                    $jobModel->_id = $model->_id;
                    $jobModel->save(false);

                    if ($oauth === true && !empty($oauthData)) {
                        Yii::$app->user->login($model);
                        return $this->goHome();
                    }

                    // Send email
                    $mailer = \Yii::$app->mailer;
                    $mailer->viewPath = '@app/modules/job/mail';

                    $sendEmail = $mailer->compose(['html' => 'registerSuccess-html', 'text' => 'registerSuccess-text'], ['model' => $model])
                        ->setFrom([\Yii::$app->params['supportEmail'] => \Yii::$app->name])
                        ->setTo($model->email)
                        ->setSubject(Yii::t('account', 'Thank you for signing up with ') . \Yii::$app->name)
                        ->send();

                    if ($sendEmail) {
                        Yii::$app->getSession()->setFlash('flash', [
                            'type' => 'success',
                            'title' => Yii::t('account', 'Thank you for signing up'),
                            'message' => Yii::t('account', 'Check your email for further instructions.'),
                            'duration' => 10000
                        ]);
                    } else {
                        Yii::$app->getSession()->setFlash('flash', [
                            'type' => 'error',
                            'title' => Yii::t('account', 'Thank you for signing up'),
                            'message' => Yii::t('account', 'Sorry, we are temporarily unable to send mail.'),
                            'duration' => 10000
                        ]);
                    }

                    return $this->redirect(['login', 'role' => $role]);
                }
            }
        }

        $renderView = ($jobModel->role == 'seeker') ? 'register-seeker' : 'register-agent';
        return $this->render($renderView, [
            'model' => $model,
            'jobModel' => $jobModel,
        ]);
    }

    public function actionProfile() {
        Yii::$app->view->title = Yii::t($this->module->id, 'Profile');
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        $this->render('profile');
    }
    
    public function actionUpgrade(){
        Yii::$app->view->title = Yii::t($this->module->id, 'Upgrade Level');
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        $this->render('upgrade');
    }
}
