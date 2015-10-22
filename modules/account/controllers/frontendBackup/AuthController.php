<?php

namespace app\modules\account\controllers\frontend;

use Yii;
use app\components\FrontendController;
use app\modules\account\models\User;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

class XAuthController extends FrontendController {

    public function behaviors() {
        $data = [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
        return array_merge(parent::behaviors(), $data);
    }

//    public function actions() {
//        return [
//            'oauth' => [
//                'class' => 'yii\authclient\AuthAction',
//                'successCallback' => [$this, 'successCallback'],
//            ],
//            'oauthtest' => [
//                'class' => 'yii\authclient\AuthAction',
//                'successCallback' => [$this, 'successCallbackTest'],
//                'successUrl' => \yii\helpers\Url::to(['auth/logintest'])
//            ],
//        ];
//    }

//    public function successCallback($client) {
//        $attributes = $client->getUserAttributes();
//        $authClient = Yii::$app->request->get('authclient');
//        $email = (!empty($attributes['email']))?$attributes['email']:'';
//        $first_name = (!empty($attributes['first_name']))?$attributes['first_name']:'';
//        $last_name = (!empty($attributes['last_name']))?$attributes['last_name']:'';
//
//        if ($authClient == 'facebook'){
//            $openid = (!empty($attributes['id']))?$attributes['id']:'';
//            $avatar = 'https://graph.facebook.com/'.$openid.'/picture';
//        } else {
//            $openid = $email;
//        }
//
//        // Check xem da dang nhap bang OpenId chua
//        $model = User::findByOpenId($openid, $authClient);
//        if (!$model) { // Truong hop chua dang nhap bang OpenId
//            $model = User::findByEmail($email);
//            echo 1;
//            if (!$model) { // Khong co Email tuong ung trong DB
//                echo 2;
//                // Insert new user
//                $model = new User;
////                $model->scenario = 'login_openid';
//                $model->email = $email;
//                $model->display_name = $first_name . ' ' . $last_name;
//                $model->first_name = $first_name;
//                $model->last_name = $last_name;
//                $model->avatar = $avatar;
//                $openids = [];
//                $openids[$authClient] = $openid;
//                $model->openids = $openids;
//                $model->status = User::STATUS_ACTIVE;
//            } else { // Ton tai tai khoan co email tuong ung
//                echo 3;
//                if (empty($model->display_name))
//                    $model->display_name = $first_name . ' ' . $last_name;
//                if (empty($model->first_name))
//                    $model->first_name = $first_name;
//                if (empty($model->last_name))
//                    $model->last_name = $last_name;
//                $openids = [];
//                $openids[$authClient] = $openid;
//                $model->openids = $openids;
//                if (empty($model->avatar))
//                    $model->avatar = $avatar;
//            }
//        }
//
//        $model->save();
//        $model->login($model);
//    }

//    public function successCallbackTest($client) {
//        $attributes = $client->getUserAttributes();
//        $authClient = Yii::$app->request->get('authclient');
//
//        // Nhan thong tin tra ve tu provider sau khi xac thuc thanh cong
//        $oauthEmail = (!empty($attributes['email'])) ? $attributes['email'] : '';
//        $oauthFirstname = (!empty($attributes['first_name'])) ? $attributes['first_name'] : '';
//        $oauthLastname = (!empty($attributes['last_name'])) ? $attributes['last_name'] : '';
//        $oauthFullname = (!empty($attributes['name'])) ? $attributes['name'] : '';
//        //$oauthAvatar = '';
//
//        if ($authClient == 'facebook') {
//            $oauthIdentity = (!empty($attributes['id'])) ? $attributes['id'] : '';
//            //$oauthAvatar = 'https://graph.facebook.com/' . $oauthIdentity . '/picture';
//        } else {
//            $oauthIdentity = $oauthEmail;
//        }
//
//        // Xu ly luu tru
//        $oauthOpenIds = [];
//        $oauthOpenIds[$authClient] = $oauthIdentity;
//
//        // Dang ky User moi (ko kiem tra bat ky dieu kien gi)
//        $model = new User;
//        $model->email = $oauthEmail;
//        $model->display_name = $oauthFullname;
//        $model->first_name = $oauthFirstname;
//        $model->last_name = $oauthLastname;
//        $model->openids = $oauthOpenIds;
//        $model->status = User::STATUS_ACTIVE;
//
//        if (!$model->save()) {
//            var_dump($model->errors);
//            die;
//        }
//        $model->login($model);
//    }

//    public function actionLogintest() {
//        $this->render('login-test');
//    }

//    public function actionIndex() {
//        $queryParams = Yii::$app->request->getQueryParams();
//        $searchModel = new User;
//        $searchModel->scenario = 'search';
//        $dataProvider = $searchModel->search($queryParams);
//        return $this->render('index', [
//            'dataProvider' => $dataProvider,
//            'searchModel' => $searchModel,
//        ]);
//    }

//    public function actionSignup() {
//        $model = new User;
//        $extraModel = new \app\modules\account\models\UserExtra;
//        $message = [];
//        if ($model->load(Yii::$app->request->post()) and $model->validate()) {
//            $model->status = User::STATUS_ACTIVE;
//            if ($model->save()) {
//                $message = [
//                    'message' => 'Đăng ký tài khoản thành công'
//                ];
////                $this->redirect($this->goBack());
//            }
//        } else{
//            $message = [
//                'message' => $model->getErrors(),
//            ];
//        }
//
//        echo json_encode($message);
////        return $this->render('signup', [
////            'model' => $model,
////            'extraModel' => $extraModel,
////        ]);
//    }
    
    public function actionRegister() {
        $isAjax = Yii::$app->request->get('ajax', '0');
        $model = new User;
        $message = [];
        $extraModel = new \app\modules\account\models\UserExtra;
        $jobModel = new \app\modules\account\models\UserJob;
        $jobModel->type = Yii::$app->request->get('type', 'recruiter');

        if ($model->load(Yii::$app->request->post()) AND $model->validate() AND ($modelAdditionBlocks = \app\helpers\LetHelper::saveAdditionBlocks($model))) {
            $model->status = User::STATUS_ACTIVE;
            if ($model->save()) {
                if (is_array($modelAdditionBlocks)) {
                    foreach($modelAdditionBlocks as $modelAdditionBlock) {
                        $modelAdditionBlock->_id = $model->_id;
                        $modelAdditionBlock->save();
                    }
                }
                $message = [
                    'message' => 'Đăng ký tài khoản thành công'
                ];
                if (!$isAjax)
                    $this->redirect($this->goBack());
            }
        } else{
            $message = [
                'message' => $model->getErrors(),
            ];
        }
        if ($isAjax)
            echo json_encode($message);
        else {
            Yii::$app->view->title = Yii::t($this->module->id, 'Register');
            Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

            $renderView = ($jobModel->type == 'recruiter') ? 'register-recruiter' : 'register-seeker';
            return $this->render($renderView, [
                'model' => $model,
                'extraModel' => $extraModel,
                'jobModel' => $jobModel,
            ]);
        }
    }

//    public function actionLogin()
//    {
//        $model = new User();
//        $model->scenario = 'login';
//        $message = [];
//        if ($model->load(Yii::$app->request->post()) && $model->login()) {
//            return $this->goBack();
//        } else {
//            $message = [
//                'message' => json_encode($model->getErrors()),
//            ];
//        }
//
//        echo json_encode($message);
//    }

//    public function actionLogout() {
//        Yii::$app->user->logout();
//
//        return $this->redirect($this->goHome());
//    }

//    /**
//     * Finds the model based on its primary key value.
//     * If the model is not found, a 404 HTTP exception will be thrown.
//     * @param string $id
//     * @return the loaded model
//     * @throws NotFoundHttpException if the model cannot be found
//     */
//    protected function findModel($id) {
//        if (($model = User::findOne($id)) !== null) {
//            return $model;
//        } else {
//            throw new NotFoundHttpException('The requested page does not exist.');
//        }
//    }

//    public function actionPasswordrequest() {
//        $model = new \app\modules\account\models\PasswordRequestForm();
//        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            if ($model->sendEmail()) {
//                Yii::$app->getSession()->setFlash('flash', [
//                    'type' => 'success',
//                    'title' => Yii::t('account', 'Message'),
//                    'message' => Yii::t('account', 'Check your email for further instructions.'),
//                    'duration' => 10000
//                ]);
//            } else {
//                Yii::$app->getSession()->setFlash('flash', [
//                    'type' => 'error',
//                    'title' => Yii::t('account', 'Message'),
//                    'message' => Yii::t('account', 'Sorry, we are unable to reset password for email provided.'),
//                    'duration' => 10000
//                ]);
//            }
//
//            return $this->goHome();
//        }
//
//        Yii::$app->view->title = Yii::t($this->module->id, 'Request password reset');
//        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;
//
//        return $this->render('password-request', [
//            'model' => $model,
//        ]);
//    }

//    public function actionPasswordreset($token) {
//        $model = new \app\modules\account\models\PasswordResetForm($token);
//
//        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
//            Yii::$app->getSession()->setFlash('flash', [
//                'type' => 'success',
//                'title' => 'Message',
//                'message' => Yii::t('account', 'New password was saved.'),
//                'duration' => 10000
//            ]);
//
//            return $this->goHome();
//        }
//
//        Yii::$app->view->title = Yii::t($this->module->id, 'Reset password');
//        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;
//
//        return $this->render('password-reset', [
//            'model' => $model,
//        ]);
//    }

//    public function actionLoginjob() {
//        if (!\Yii::$app->user->isGuest) {
//            return $this->goHome();
//        }
//
//        $model = new User();
//        $model->scenario = 'login';
//
//        if ($model->load(Yii::$app->request->post()) && $model->login()) {
//            return $this->goBack();
//        }
//
//        Yii::$app->view->title = Yii::t($this->module->id, 'Login');
//        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;
//
//        return $this->render('login', [
//            'model' => $model,
//        ]);
//    }
}
