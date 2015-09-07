<?php

namespace app\modules\classified\controllers\frontend;

use Yii;
use app\components\FrontendController;
use app\modules\category\models\Category;
use app\modules\question\models\Question;
use yii\data\ActiveDataProvider;

class DefaultController extends FrontendController {

    public function actionIndex($id, $module = null) {
        if ($module != 'faq')
            $query = Question::find();
        else 
            $query = \app\modules\faq\models\Faq::find();
        $query->orderBy('_id ASC');
        $query->where(['category' => $id]);
        
        Yii::$app->view->title = Category::findOne($id)->name;
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
        
        return $this->render('index',['model' => $dataProvider]);
    }
    
//    public function actionFaq($id) {
//        $query = Question::find();
//        $query->orderBy('_id ASC');
//        $query->where(['category' => $id, 'need_answer' => 1, 'status' => 1]);
//        
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//            'pagination' => [
//                'pageSize' => 10,
//            ],
//        ]);
//        
//        return $this->render('faq',['model' => $dataProvider]);
//    }
    
    public function actionDoctor($id) {
        $query = Question::find();
        $query->orderBy('_id ASC');
        $query->where(['category' => $id, 'need_answer' => 1]);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        
        return $this->render('doctor',['model' => $dataProvider]);
    }

}
