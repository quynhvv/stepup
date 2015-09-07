<?php

namespace app\modules\common;

use Yii;

class Module extends \app\components\Module
{
    public $controllerNamespace = 'app\modules\common\controllers';

    public $iconClass = 'dashboard';
    
    public $backendMenu = [];
    
    public function init()
    {
        parent::init();

        $this->backendMenu = [
            [
                'label' => Yii::t('common', 'Import Excel'),
                'url' => ['/common/import'],
                'access' => [
                    'common/import'
                ]
            ],
            [
                'label' => Yii::t('common', 'Setting'),
                'url' => ['/common/setting'],
                'access' => [
                    'common/setting'
                ]
            ],
        ];
    }
}
