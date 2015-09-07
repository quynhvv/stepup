<?php

namespace app\modules\job\controllers\backend;

use Yii;
use yii\data\ActiveDataProvider;
use app\components\BackendController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use app\modules\job\models\User;
use app\modules\job\models\UserJob;
use app\modules\job\models\UserJobSeekerResume;

/**
 * AccountController implements the CRUD actions for UserJob model.
 */
class ReportController extends BackendController
{

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

    public function actionMember()
    {
        Yii::$app->view->title = Yii::t('job', 'Member Report');
        Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t('job', 'Member Report'), 'url' => ['member']];

        return $this->render('member');
    }

    public function actionJob()
    {
        Yii::$app->view->title = Yii::t('job', 'Job Report');
        Yii::$app->view->params['breadcrumbs'][] = ['label' => Yii::t('job', 'Job Report'), 'url' => ['job']];

        return $this->render('job');
    }

}
