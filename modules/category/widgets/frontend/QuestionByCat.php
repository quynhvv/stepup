<?php

namespace app\modules\category\widgets\frontend;

use yii;
use yii\base\Widget;
use app\modules\category\models\Category;
use app\modules\question\models\Question;
use app\modules\comment\models\Comment;
use yii\db\Query;

class QuestionByCat extends Widget{
    
    public $view='QuestionByCat';
    public $name='';
    public $cat_id;
    public $type='';
    
    public function init() {
        parent::init();
    }
    
    public function run() {
        switch ($this->type) {
            case '':
                $questions = Question::find()->where(['category' => $this->cat_id])->limit(10)->orderBy('rand()')->all();
                break;
            case 'comment':
                $questions = Question::find()->where(['count_comment' => ['$gt' => 0]])->limit(10)->orderBy('rand()')->all();
                break;
            case 'cat':
                $questions = Category::find()->where(['lft' => ['$gt' => 1], 'module' => 'question'])->limit(4)->orderBy('rand()')->all();
            default:
                break;
        }
        
        $assign = [
            'questions' => $questions, 
            'name' => $this->name
        ];
        
        return $this->render($this->view, $assign);
    }
    
}

