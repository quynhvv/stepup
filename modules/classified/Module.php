<?php

namespace app\modules\classified;

use Yii;

class Module extends \app\components\Module
{
    public $controllerNamespace = 'app\modules\classified\controllers';

    public $iconClass = 'bullhorn';
    
    public $backendMenu = [];

    public function init()
    {
        parent::init();

        // custom initialization code goes here
        // Menu backend
        $this->backendMenu = [
            [
                'label' => Yii::t('classified', 'Classified'),
                'url' => ['/classified/default'],
                'access' => [
                    'classified/backend/default/*',
                ],
            ],
        ];
    }
}
