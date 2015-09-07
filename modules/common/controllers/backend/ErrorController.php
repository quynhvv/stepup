<?php

namespace app\modules\common\controllers\backend;

use Yii;
use yii\web\Controller;

class ErrorController extends Controller {

    public $layout = false;

    public function actions() {
        parent::actions();
        return [
            'index' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

//    public function beforeAction($action) {
////        $this->layout = 'main';
//        parent::beforeAction($action);
//    }

}
