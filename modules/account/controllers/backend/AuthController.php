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
}
