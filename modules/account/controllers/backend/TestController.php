<?php

namespace app\modules\account\controllers\backend;

use Yii;
use app\components\BackendController;
use app\modules\account\models\User;

class TestController extends BackendController {
   
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
        echo 111;
    }

}
