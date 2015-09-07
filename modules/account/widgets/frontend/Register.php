<?php

namespace app\modules\account\widgets\frontend;

use Yii;
use yii\base\Widget;
use app\modules\account\models\User;
use yii\helpers\Url;
use yii\helpers\Html;

class Register extends Widget{
    
    public $isAjax = false;
    
    public function init() {
        parent::init();
    }
    
    public function run() {
        $this->registerAssets();
        $model = new User();
        $model->scenario = 'register';

        if ($this->isAjax)
            $this->registerAssets();
        
        return $this->render('Register', [
            'model' => $model,
            'isAjax' => $this->isAjax,
        ]);

//        if ($this->typeLogin === 'ajax') {
//            Html::a(Yii::t('account', 'Signup'), null, ['data-toggle' => 'modal', 'data-target' => '#registerModal', 'style' => 'cursor: pointer;']);
//            return $this->render('SignupModal', [
//                'model' => $model,
//            ]);
//        } else
//            echo Html::a(Yii::t('account', 'Signup'), $this->url);
    }
    
    private function registerAssets(){
        Yii::$app->view->registerJs("
            function register() {
                jQuery.ajax({
                    url: '" . Url::to(['/account/frontend/auth/register']) . "',
                    type: 'POST',
                    dataType: 'json',
                    data: $('#register-form').serialize(),
                }).done(function (msg){
                    $('#msgSignup').show();
                    $('#msgSignup').text(msg.message);
                    $('#register-form').trigger('reset');
                });
            }   
        ", \yii\web\View::POS_END);
    }
    
}

