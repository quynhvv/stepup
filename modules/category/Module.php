<?php

namespace app\modules\category;

class Module extends \app\components\Module
{
    public $controllerNamespace = 'app\modules\category\controllers';

    public $iconClass = 'tree-conifer';
    
    public $backendMenu = [];

    public function init()
    {
        parent::init();

        // custom initialization code goes here
    }
}
