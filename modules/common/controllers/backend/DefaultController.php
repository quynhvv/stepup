<?php

namespace app\modules\common\controllers\backend;

use Yii;
use app\components\BackendController;
use yii\helpers\Json;
use yii\filters\VerbFilter;

class DefaultController extends BackendController
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

    public function actionIndex()
    {
        Yii::$app->view->title = Yii::t('common', 'Dashboard');
        return $this->render('index');
    }

    public function actionCache()
    {
        Yii::$app->cache->flush();
        Yii::$app->getSession()->setFlash('flash', [
            'type' => 'success',
            'title' => Yii::t('common', 'Message'),
            'message' => Yii::t('common', 'You\'ve successfully cleared the system cache'),
            'duration' => 10000
        ]);
        return $this->redirect(['index']);
    }
}
