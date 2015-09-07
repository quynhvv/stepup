<?php

namespace app\modules\common\widgets\frontend;

use Yii;
use yii\base\Widget;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;

class Comment extends Widget{
    
    public $_params;
    
    public function init() {
        $this->registerAssets();
        parent::init();
    }
    
    public function run() {
        $module = ArrayHelper::getValue($this->_params, 'module');
        $view = ArrayHelper::getValue($this->_params, 'view');
        
        $comment = \app\modules\comment\models\Comment::find();
        $comment->orderBy('create_time DESC');
        $comment->where(['status' => 1, 'item_id' => ArrayHelper::getValue($this->_params, 'parent_id'), 'module' => (!empty($module)) ? $module: 'comment']);
        
        $dataProvider = new ActiveDataProvider([
            'query' => $comment,
            'pagination' => false,
        ]);
        
        $this->_params['model'] = $dataProvider;
        
        return $this->render((!empty($view)) ? $view : 'comment', $this->_params);
    }
    
    private function registerAssets(){
        Yii::$app->view->registerJS("
            function checkEnter(event, element) {
                if (event.keyCode == 13) {
                    $('#formDefault').submit();
                }
            }
            
            $('.buttonLike').click(function(){
                var id = '" . ArrayHelper::getValue($this->_params, 'parent_id') . "';
                var type = $(this).attr('data-type');
                var comment_id = $(this).attr('data-id');
                $.ajax({
                    url: '" . yii\helpers\Url::to(['/question/ajax/like']) . "',
                    type: 'post',
                    data: {type: type, comment_id: comment_id, id: id},
                }).done(function (status) {
                    if (status != 1){
                        $('.buttonLike[data-id=\"' + comment_id + '\"]').text('Like')
                        $('.buttonLike[data-id=\"' + comment_id + '\"]').attr('data-type', 'like');
                    } else {
                        $('.buttonLike[data-id=\"' + comment_id + '\"]').text('Unlike')
                        $('.buttonLike[data-id=\"' + comment_id + '\"]').attr('data-type', 'unlike');
                    }
                });
            });
        ", yii\web\View::POS_END);
    }
    
}

