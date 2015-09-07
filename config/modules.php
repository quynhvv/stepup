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
        'article' => [
            'class' => 'app\modules\article\Module',
        ],
        'question' => [
            'class' => 'app\modules\question\Module',
        ],
        'faq' => [
            'class' => 'app\modules\faq\Module',
        ],
    	'category' => [
            'class' => 'app\modules\category\Module',
        ],
        'comment' => [
            'class' => 'app\modules\comment\Module',
        ],
        'chat' => [
            'class' => 'app\modules\chat\Module',
        ],        
        'product' => [
            'class' => 'app\modules\product\Module',
        ],
        'classified' => [
            'class' => 'app\modules\classified\Module',
        ],
        'sms' => [
            'class' => 'app\modules\sms\Module',
        ],
        'film' => [
            'class' => 'app\modules\film\Module',
        ],
        'job' => [
            'class' => 'app\modules\job\Module',
        ],
        'bizo' =>  [
            'class' => 'app\modules\bizo\Module',
        ],
        'location' =>  [
            'class' => 'app\modules\location\Module',
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
                'article' => ['class' => 'yii\i18n\PhpMessageSource', 'basePath' => '@app/modules/article/messages'],
            	'question' => ['class' => 'yii\i18n\PhpMessageSource', 'basePath' => '@app/modules/question/messages'],
            	'faq' => ['class' => 'yii\i18n\PhpMessageSource', 'basePath' => '@app/modules/faq/messages'],
            	'product' => ['class' => 'yii\i18n\PhpMessageSource', 'basePath' => '@app/modules/product/messages'],
            	'film' => ['class' => 'yii\i18n\PhpMessageSource', 'basePath' => '@app/modules/film/messages'],
            	'chat' => ['class' => 'yii\i18n\PhpMessageSource', 'basePath' => '@app/modules/chat/messages'],
            	'job' => ['class' => 'yii\i18n\PhpMessageSource', 'basePath' => '@app/modules/job/messages'],
            	'classified' => ['class' => 'yii\i18n\PhpMessageSource', 'basePath' => '@app/modules/classified/messages'],
            	'location' => ['class' => 'yii\i18n\PhpMessageSource', 'basePath' => '@app/modules/location/messages'],
            	'comment' => ['class' => 'yii\i18n\PhpMessageSource', 'basePath' => '@app/modules/comment/messages'],
            	'bizo' => ['class' => 'yii\i18n\PhpMessageSource', 'basePath' => '@app/modules/bizo/messages'],
            	'sms' => ['class' => 'yii\i18n\PhpMessageSource', 'basePath' => '@app/modules/sms/messages'],
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