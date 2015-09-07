<?php

namespace app\modules\account\widgets\frontend;

use yii;
use yii\base\Widget;
use app\modules\account\models\User;
use yii\helpers\Url;

class AccountBlock extends Widget{
    
    public $type;
    
    public function init() {
        parent::init();
    }
    
    public function run() {
        $model = new User();
        return $this->render('accountblock', [
            'model' => $model,
        ]);
    }
    
}

