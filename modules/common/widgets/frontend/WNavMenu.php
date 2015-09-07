<?php

namespace app\modules\common\widgets\frontend;

use yii\base\Widget;
use app\modules\category\models\LetCategory;

class WNavMenu extends Widget{
    
    public function init() {
        parent::init();
    }
    
    public function run() {
        return $this->render('navmenu');
    }
    
}

