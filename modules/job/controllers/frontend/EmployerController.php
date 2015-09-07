<?php

namespace app\modules\job\controllers\frontend;

use Yii;
use app\components\FrontendController;
use yii\filters\VerbFilter;
use app\modules\job\models\UserJob;

class EmployerController extends FrontendController
{

    public function beforeAction($action)
    {
        // check logined & role
        UserJob::checkAccess('employer');

        return parent::beforeAction($action);
    }

    public function actionIndex()
    {
        Yii::$app->view->title = Yii::t($this->module->id, 'Employer');
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        $this->render('index');
    }

    public function actionDashboard() {
        Yii::$app->view->title = Yii::t($this->module->id, 'Dashboard');
        Yii::$app->view->params['breadcrumbs'][] = Yii::$app->view->title;

        $this->render('dashboard');
    }
}
