<?php

namespace app\modules\message;

use Yii;

class Module extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\message\controllers';

    public $iconClass = 'pencil';

    public $hasCategory = false;

    public $backendMenu = [];

    public function init()
    {
        // Menu backend
        $this->backendMenu = [
            [
                'label' => Yii::t('message', 'Message'),
                'url' => ['/message/default'],
                'access' => [
                    'message/backend/default/*',
                    'message/backend/default/index',
                ],
            ],
            [
                'label' => Yii::t('common', 'Setting'),
                'url' => ['/common/setting', 'module' => 'message'],
                'access' => [
                    'common/setting',
                ],
            ],
        ];

        parent::init();

        // custom initialization code goes here
    }
}
