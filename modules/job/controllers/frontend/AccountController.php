<?php

namespace app\modules\job\controllers\frontend;

use Yii;
use app\components\FrontendController;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;

use app\modules\job\models\User;
use app\modules\job\models\UserJob;
use app\modules\job\models\UserJobSeekerResume;
use app\modules\job\models\UserJobProfileViewLog;
use app\modules\job\models\UserFavourite;

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
        $model->role = $role;

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (isset($_GET['return'])) {
                return $this->redirect($_GET['return']);
            }

            return $this->redirect(["/job/{$role}/index"]);
        }

        Yii::$app->view->title = Yii::t($this->module->id, 'Sign in');
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        return $this->render('login', [
            'model' => $model,
            'role' => $role
        ]);
    }

//    public function actionLoginBackup() {
//        if (!Yii::$app->user->isGuest) {
//            return $this->goHome();
//        }
//
//        $role = Yii::$app->request->getQueryParam('role', UserJob::$roleDefault);
//        if (!in_array($role, UserJob::$roleAllows)) {
//            $role = UserJob::$roleDefault;
//        }
//
//        $model = new User();
//        $model->scenario = 'login';
//        $model->role = $role;
//
//        if ($model->load(Yii::$app->request->post()) && $model->login()) {
//            if (isset($_GET['return'])) {
//                return $this->redirect($_GET['return']);
//            }
//
//            $modelJob = UserJob::find()->where(['_id' => Yii::$app->user->id, 'role' => $role])->one();
//            if ($modelJob != null) {
//
//                // Kiem tra xem Seeker da co day du thong tin Resume chua?
//                if ($role == 'seeker' && ($modelUserJobSeekerResume = UserJobSeekerResume::findOne($modelJob->_id)) != null) {
//                    Yii::$app->session->set('jobAccountResume', 1);
//                }
//
//                Yii::$app->session->set('jobAccountRole', $modelJob->role);
//                return $this->redirect(["/job/{$modelJob->role}/index"]);
//            }
//
//            // Neu kiem tra role khong hop le thi logout roi yeu cau login lai
//            Yii::$app->getSession()->setFlash('flash', [
//                'type' => 'error',
//                'title' => Yii::t('account', 'Login Error'),
//                'message' => Yii::t('account', 'You are not allowed to access this page.'),
//                'duration' => 10000
//            ]);
//            return $this->redirect(['/job/account/logout', 'role' => $role]);
//        }
//
//        Yii::$app->view->title = Yii::t($this->module->id, 'Sign in');
//        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;
//
//        return $this->render('login', [
//            'model' => $model,
//            'role' => $role
//        ]);
//    }

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
                
                //set user display name from email, and user can change later
                $model->display_name = substr($model->email, 0, strpos($model->email, '@'));

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

    public function actionPublicProfile() {
        
        $displayName = Yii::$app->request->getQueryParam('display_name');
        $user = User::find()->where(['display_name' => $displayName])->one();
        if ($displayName AND $user){
            
            // Log view for user
            if (UserJob::checkRole('recruiter') OR UserJob::checkRole('employer')){
                $log = UserJobProfileViewLog::find()->where(['user_id' => $user->_id, 'view_by_user_id' => Yii::$app->user->id])->one();
                if (!$log){
                    $log = new UserJobProfileViewLog();
                    $log->user_id = $user->_id;
                    $log->view_by_user_id = Yii::$app->user->id;
                    $log->hits = 1;
                    $log->last_view_date = new \MongoDate();
                }else{
                    $log->hits = $log->hits + 1;
                    $log->last_view_date = new \MongoDate();
                }
                $log->save();
            }
            
            Yii::$app->view->title = Yii::t($this->module->id, ucfirst($displayName) . "'s Profile");
            Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;
                
            return $this->render("public_profile_{$user->userJob->role}", ['user' => $user]);
        } else{
            return $this->goHome();
        }
        
    }
    
    public function actionFavourite() {
        Yii::$app->response->format = 'json';

        $params = Yii::$app->request->post();
        $result = array();
        
        $model = UserFavourite::findOne(['object_id' => $params['object_id'], 'object_type' => $params['object_type'], 'created_by' => Yii::$app->user->id]);
        if (!$model){
            $model = new UserFavourite();
            $model->setScenario('create');
            $model->object_id = $params['object_id'];
            $model->object_type = $params['object_type'];
            $model->created_by = Yii::$app->user->id;
            $model->created_time = new \MongoDate();
            if ($model->save()){
                $result['status'] = 'ok';
                $result['action'] = 'add';
                $result['message'] = Yii::t('job', 'Added to favourites list successfully.');
            } else{
                $result['status'] = 'fail';
                $result['message'] = Yii::t('job', 'There is a error. Please try a gain.');
            }
        } else{
            //unfavourite
            if ($model->delete()){
                $result['status'] = 'ok';
                $result['action'] = 'remove';
                $result['message'] = Yii::t('job', 'Removed from favourites list successfully.');
            } else {
                $result['status'] = 'fail';
                $result['message'] = Yii::t('job', 'There is a error. Please try a gain.');
            }
        }

        return $result;
    }
    
    public function actionUpgrade(){
        Yii::$app->view->title = Yii::t($this->module->id, 'Upgrade Level');
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        return $this->render('upgrade');
    }
}
