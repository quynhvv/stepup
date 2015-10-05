<?php

namespace app\modules\common\controllers\frontend;

use Yii;
use app\components\FrontendController;

class DefaultController extends FrontendController
{

    public function actions()
    {
        return [
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction'
            ],
        ];
    }

    public function actionIndex()
    {
//        $newQuestion = Question::find()
//                ->where(['status' => 1])
//                ->orderBy('_id DESC')
//                ->one();
//        
//        $answersQuestion = Question::find()
//                ->where([
//                    'status' => 1,
//                    'count_comment' => 0
//                ])
//                ->orderBy('_id DESC')
//                ->one();

        return $this->render('index');
    }

    public function actionInfomation()
    {
        $this->layout = '//infomation';
        return $this->render('infomation');
    }
}
