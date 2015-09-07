<?php

namespace app\modules\common\widgets\frontend;

use yii\base\Widget;
use app\modules\question\models\Question;

class SideBar extends Widget{
    
    public function init() {
        parent::init();
    }
    
    public function run() {
        // Get list category of module question
        $model = \app\modules\category\models\Category::getCategory('question', '- ');
        
        // Get question quan tam nhieu nhat
        $concernedQuestion = Question::find()
            ->where(['status' => 1])
            ->andWhere(['stats.comment_count' => ['$gt' => 0]])
            ->orderBy(['stats.comment_count' => -1])
            ->limit(5)
            ->all();
        
        return $this->render('sidebar', ['model' => $model, 'concernedQuestion' => $concernedQuestion]);
    }
    
}

