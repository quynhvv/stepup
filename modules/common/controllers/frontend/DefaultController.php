<?php

namespace app\modules\common\controllers\frontend;

use Yii;
use app\components\FrontendController;
use app\modules\question\models\Question;
use yii\data\ActiveDataProvider;

class DefaultController extends FrontendController
{
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
    
    public function actionInfomation(){
        $this->layout = '//infomation';
        return $this->render('infomation');
    }
}
