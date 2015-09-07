<?php

return [
    'modules' => [
        'common' => [
            'class' => 'app\modules\common\Module',
        ],
        'gridview' =>  [
            'class' => '\kartik\grid\Module',
        ],
        'dynagrid' =>  [
            'class' => '\kartik\dynagrid\Module',
        ],
        'account' => [
            'class' => 'app\modules\account\Module',
            'additionBlocks' => [
                'user_extra' => 'app\modules\account\models\UserExtra',
                'user_job' => 'app\modules\account\models\UserJob',
            ],
        ],
        
    	'category' => [
            'class' => 'app\modules\category\Module',
        ],
        
        'classified' => [
            'class' => 'app\modules\classified\Module',
        ],
        'job' => [
            'class' => 'app\modules\job\Module',
        ],
        'datecontrol' =>  [
            'class' => '\kartik\datecontrol\Module'
        ],
        'diy' => [
            'class' => '\letyii\diy\Module',
            'permissionName' => [
                'index' => '',
                'create' => '',
                'update' => '',
                'delete' => '',
                'build' => '',
            ]
        ],
    ],
    'components' => [
        'i18n' => [
            'translations' => [
                'common' => ['class' => 'yii\i18n\PhpMessageSource', 'basePath' => '@app/modules/common/messages'],
            	'category' => ['class' => 'yii\i18n\PhpMessageSource', 'basePath' => '@app/modules/category/messages'],
                'account' => ['class' => 'yii\i18n\PhpMessageSource', 'basePath' => '@app/modules/account/messages'],
            	'job' => ['class' => 'yii\i18n\PhpMessageSource', 'basePath' => '@app/modules/job/messages'],
            	'classified' => ['class' => 'yii\i18n\PhpMessageSource', 'basePath' => '@app/modules/classified/messages'],
            	'location' => ['class' => 'yii\i18n\PhpMessageSource', 'basePath' => '@app/modules/location/messages'],
            	'diy' => ['class' => 'yii\i18n\PhpMessageSource', 'basePath' => '@app/messages'],
                'gridview' => ['class' => 'yii\i18n\PhpMessageSource', 'basePath' => '@app/messages'],
                'kvgrid' => ['class' => 'yii\i18n\PhpMessageSource', 'basePath' => '@app/messages'],
//                'gridview' => [
//                    'class' => 'yii\i18n\PhpMessageSource',
//                    'basePath' => '@kvgrid/messages',
//                    'forceTranslation' => true,
//                ]
            ],
        ],
    ],
];