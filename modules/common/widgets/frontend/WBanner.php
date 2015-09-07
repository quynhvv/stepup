<?php

namespace app\modules\common\widgets\frontend;

use yii\base\Widget;

class WBanner extends Widget{
    
    public function init() {
        parent::init();
    }
    
    public function run() {
        return $this->render('banner');
    }
    
}

