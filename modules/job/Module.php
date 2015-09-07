<?php

namespace app\modules\job;

use Yii;

class Module extends \app\components\Module
{
    public $controllerNamespace = 'app\modules\job\controllers';
    
    public $hasCategory = true;
    
    public $iconClass = 'briefcase';

    public $backendMenu = [];
    
    public function init()
    {
        // Menu backend
        $this->backendMenu = [
            [
                'label' => Yii::t('job', 'Manage Job'),
                'url' => ['/job/default'],
                'access' => [
                    'job/backend/default/*',
                ],
            ],
            [
                'label' => Yii::t('category', 'Manage Category'),
                'url' => ['/category/default', 'module' => 'job'],
                'access' => [
                    'category/backend/default/*',
                ],
            ],
            [
                'label' => Yii::t('job', 'Manage Function'),
                'url' => ['/job/function'],
                'access' => [
                    'job/backend/function/*',
                ],
            ],
            [
                'label' => Yii::t('job', 'Manage Industry'),
                'url' => ['/job/industry'],
                'access' => [
                    'job/backend/industry/*',
                ],
            ],
            [
                'label' => Yii::t('job', 'Manage Location'),
                'url' => ['/job/location'],
                'access' => [
                    'job/backend/location/*',
                ],
            ],
            [
                'label' => Yii::t('job', 'Manage Salary'),
                'url' => ['/job/salary'],
                'access' => [
                    'job/backend/salary/*',
                ],
            ],
            [
                'label' => Yii::t('job', 'Manage Work Types'),
                'url' => ['/job/worktype'],
                'access' => [
                    'job/backend/worktype/*',
                ],
            ],
            [
                'label' => Yii::t('job', 'Manage Members'),
                'url' => ['/job/account'],
                'access' => [
                    'job/backend/account/*',
                ],
            ],
            [
                'label' => Yii::t('job', 'Manage VIP Packages'),
                'url' => ['/job/vip/index'],
                'access' => [
                    'job/backend/vip/index'
                ]
            ],
            [
                'label' => Yii::t('job', 'Member Report'),
                'url' => ['/job/report/member'],
                'access' => [
                    'job/backend/report/member'
                ]
            ],
            [
                'label' => Yii::t('job', 'Job Report'),
                'url' => ['/job/report/job'],
                'access' => [
                    'job/backend/report/job'
                ]
            ],
            [
                'label' => Yii::t('common', 'Settings'),
                'url' => ['/common/setting', 'module' => 'job'],
                'access' => [
                    'common/setting',
                ],
            ],
        ];
        
        parent::init();
    }
}
