<?php

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'language' => 'en',
    'bootstrap' => ['log'],
    'defaultRoute' => 'common/backend/default',
    'extensions' => require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\modules\account\models\User',
            'loginUrl' => ['/account/backend/auth/login'],
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'common/backend/error',
        ],
        'mail' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
//                [
//                    'class' => 'yii\log\FileTarget',
//                    'levels' => ['error', 'warning'],
//                ],
                [
                    'class' => 'yii\mongodb\log\MongoDbTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => true,
            'rules' => [
                'gii/<controller:\w+>' => 'gii/<controller>/index',
                'gii/<controller:\w+>/<action:\w+>' => 'gii/<controller>/<action>',
                
                'gridview/<controller:\w+>' => 'gridview/<controller>/index',
                'gridview/<controller:\w+>/<action:\w+>' => 'gridview/<controller>/<action>',
                
                'diy/<controller:\w+>' => 'diy/<controller>/index',
                'diy/<controller:\w+>/<action:\w+>' => 'diy/<controller>/<action>',
                
                '<module:\w+>/<controller:\w+>' => '<module>/backend/<controller>/index',
                '<module:\w+>/<controller:\w+>/<action>' => '<module>/backend/<controller>/<action>',
//                '<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/backend/<controller>/<action>',
            ]
        ],
//        'imageCache' => [
//            'class' => 'letyii\imagecache\ImageCache',
//            'cachePath' => '@app/uploads/cache',
//            'cacheUrl' => __DIR__ . '/../letyii/letyii/uploads/cache',
//        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/themes/backend/views',
                    '@app/modules' => '@app/themes/backend/modules',
                    '@app/widgets' => '@app/themes/backend/widgets',
                ],
                'basePath' => '@app/themes/backend',
                'baseUrl' => '@web/themes/backend',
            ],
        ],
//
//        'i18n' => array(
//            'translations' => array(
//                'eauth' => array(
//                    'class' => 'yii\i18n\PhpMessageSource',
//                    'basePath' => '@eauth/messages',
//                ),
//            ),
//        ),
    ],
];


// Merge data config
$configs = array_replace_recursive(
        require(__DIR__ . '/common.php'), require(__DIR__ . '/modules.php'), require(__DIR__ . '/db.php'), require(__DIR__ . '/params.php'), $config, require(__DIR__ . '/local.php')
);

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $configs['bootstrap'][] = 'debug';
    $configs['modules']['debug'] = [
        'class' => 'yii\\debug\\Module',
        'panels' => [
            'mongodb' => [
                'class' => 'yii\\mongodb\\debug\\MongoDbPanel',
            ],
        ],
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.*'],
    ];
    $configs['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['127.0.0.1', '::1', '192.168.*'],
        'generators' => [
            'mongoDbModel' => [
                'class' => 'yii\mongodb\gii\model\Generator',
            ],
            'mongoDbModelPlus' => [
                'class' => 'app\modules\gii\generators\model\Generator',
            ],
            'mongoDbCrudPlus' => [
                'class' => 'app\modules\gii\generators\crud\Generator',
            ],
//            'letyiimodule' => [ //name generator
//                'class' => 'letyii\gii\generators\letyiimodule\Generator', //class generator
//            ],
//            'letyiimodel' => [ //name generator
//                'class' => 'letyii\gii\generators\letyiimodel\Generator', //class generator
////                'templates' => [ //setting for out templates
////                    'default' => '@app\vendor\letyii\yii2-gii\generators\letyiimodel\default', //name template => path to template
////                ]
//            ],
//            'letyiicrud' => [ //name generator
//                'class' => 'letyii\gii\generators\letyiicrud\Generator', //class generator
//            ],
        ],
    ];
}

return $configs;
