<?php

namespace app\modules\account\widgets\frontend;

use Yii;
use letyii\diy\components\DiyWidget;
use app\modules\account\models\User;
use yii\helpers\Url;
use yii\helpers\Html;

class Login extends DiyWidget{
    
    public $isAjax = false;
    
    public function init() {
        parent::init();
    }
    
    public function run() {
        $model = new User();
        
        if ($this->isAjax)
            $this->registerAssets();
        
        return $this->render('Login', [
            'model' => $model,
            'isAjax' => $this->isAjax,
        ]);
    }
    
    private function registerAssets(){
        Yii::$app->view->registerJs("
            function login() {
                jQuery.ajax({
                    url: '" . Url::to(['/account/frontend/auth/login']) . "',
                    type: 'POST',
                    dataType: 'json',
                    data: $('#login-form').serialize(),
                }).done(function (msg){
                    $('#msgLogin').show();
                    $('#msgLogin').text(msg.message);
                });
            }   
        ", \yii\web\View::POS_END);
    }
}

