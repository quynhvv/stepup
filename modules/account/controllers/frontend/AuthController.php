<?php

namespace app\modules\account\controllers\frontend;

use Yii;
use yii\helpers\Url;

use app\components\FrontendController;
use app\helpers\StringHelper;

use app\modules\account\models\User;


class AuthController extends FrontendController
{

    public function actions()
    {
        return [
            'oauth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
                'successUrl' => Url::to(['auth/oauth-success'])
            ],
        ];
    }

    public function successCallback($client)
    {
        $attributes = $client->getUserAttributes();

        $authProvider = Yii::$app->request->getQueryParam('authclient');
        $authUid = (!empty($attributes['id'])) ? $attributes['id'] : '';
        $authEmail = (!empty($attributes['email'])) ? $attributes['email'] : '';
        $authFirstname = (!empty($attributes['first_name'])) ? $attributes['first_name'] : '';
        $authLastname = (!empty($attributes['last_name'])) ? $attributes['last_name'] : '';

        if ($authProvider == 'google') {
            if (isset($attributes['displayName'])) {
                $authFirstname = $attributes['displayName'];
            }
            if (isset($attributes['emails'][0]['value'])) {
                $authEmail = $attributes['emails'][0]['value'];
            }
        }

        Yii::$app->session->set('user.auth', [
            'provider' => $authProvider,
            'uid' => $authUid,
            'email' => $authEmail,
            'name' => $authFirstname . ' ' . $authLastname,
            'firstname' => $authFirstname,
            'lastname' => $authLastname,
        ]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new User(['scenario' => 'login']);
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            if (isset($_GET['return'])) {
                return $this->redirect($_GET['return']);
            }

            return $this->redirect(Yii::$app->user->getReturnUrl());
        }

        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionLoginAjax()
    {
        Yii::$app->response->format = 'json';

        $model = new User(['scenario' => 'login']);
        $model->scenario = 'login';
        if ($model->load(Yii::$app->request->post())) {
            if ($model->login()) {
                return [
                    'status' => 1
                ];
            }

            return [
                'status' => 0,
                'message' => $model->getErrors()
            ];
        }

        return [
            'status' => 0
        ];
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionOauthSuccess()
    {
        /* @var $modelUser \app\modules\account\models\User */

        $auth = Yii::$app->session->get('user.auth');
        Yii::$app->session->remove('user.auth');

        if (empty($auth)) {
            return $this->goHome();
        }

        // Đã đăng ký OAuth
        $modelUserOauth = User::findByOpenId($auth['uid'], $auth['provider']);
        if ($modelUserOauth !== null) {
            if (($modelUser = User::findByEmail($modelUserOauth->email)) !== null) {
                Yii::$app->user->login($modelUser);
                return $this->goHome();
            }
        }

        // Chưa đăng ký OAuth -> Kiểm tra email tồn tại hay chưa
        if ($auth['email'] != '') {
            $modelUserByEmail = User::findByEmail($auth['email']);
            if ($modelUserByEmail != null) {
                if (empty($modelUserByEmail->display_name))
                    $modelUserByEmail->display_name = $auth['name'];
                if (empty($modelUserByEmail->first_name))
                    $modelUserByEmail->first_name = $auth['firstname'];
                if (empty($modelUserByEmail->last_name))
                    $modelUserByEmail->last_name = $auth['lastname'];

                $modelUserByEmail->openids = [
                    $auth['provider'] => $auth['uid']
                ];

                $modelUserByEmail->save();

                Yii::$app->user->login($modelUserByEmail);
                return $this->goHome();
            }
        }

//        // Chuyen sang trang dang ky account
//        return $this->redirect(['/account/frontend/registration/register', 'oauth' => StringHelper::encrypt($auth)]);


        // Đăng ký tự động user mới (1 vai truong hop thay ko on lam)
        $model = new User;
        $model->email = $auth['email'];
        $model->display_name = $auth['name'];
        $model->first_name = $auth['firstname'];
        $model->last_name = $auth['lastname'];
        $model->openids = [
            $auth['provider'] => $auth['uid']
        ];
        $model->status = User::STATUS_ACTIVE;
        if ($model->save()) {
            Yii::$app->user->login($model);
        }

        return $this->goHome();
    }
}
