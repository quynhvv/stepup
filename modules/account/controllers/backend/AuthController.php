<?php

namespace app\modules\account\controllers\backend;

use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use app\components\BackendController;
use app\modules\account\models\User;
use yii\helpers\Url;

class AuthController extends BackendController
{

    public $layout = '/login';

    public function behaviors()
    {
        return [];
    }

    public function actions() {
        return [
            'oauth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'successCallback'],
                'successUrl' => Url::to(['success'])
            ],
        ];
    }
    
    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new User();
        $model->scenario = 'login';
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->redirect(Yii::$app->user->loginUrl);
    }

    public function actionTest()
    {
        var_dump(Yii::$app->user->isGuest);
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
        /* @var $user \app\modules\account\models\User */

        $auth = Yii::$app->session->get('user.auth');
        Yii::$app->session->remove('user.auth');

        if (empty($auth)) {
            return $this->goHome();
        }

        $user = User::findByOpenId($auth['uid'], $auth['provider']);
        if ($user !== null) {
            Yii::$app->user->login($user);
            return $this->goHome();
        }

        var_dump($auth);
        // Đăng ký account
        //return $this->redirect(['register', 'oauth' => $this->_encrypt($auth)]);
    }
}
