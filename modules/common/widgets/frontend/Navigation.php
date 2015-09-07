<?php

namespace app\modules\common\widgets\frontend;

use yii\base\Widget;


class Navigation extends Widget{
    
    public $position = 'top';

    public function init() {
        parent::init();
    }
    
    public function run() {
        return $this->render('Navigation', ['position' => $this->position]);
    }
    
}

