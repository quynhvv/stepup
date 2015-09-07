<?php

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'language' => 'vi',
    'bootstrap' => ['log'],
    'defaultRoute' => 'common/api/default',
    'extensions' => require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'errorHandler' => [
            'errorAction' => 'common/backend/error',
        ],
        'user' => [
            'identityClass' => 'app\modules\account\models\User',
            'loginUrl' => ['/account/backend/auth/login'],
            'enableAutoLogin' => true,
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
        'request' => [
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ],
        ],
		'urlManager' => [ 
			'enablePrettyUrl' => true,
            'showScriptName' => true,
			'rules' => [
        		'<module:\w+>/<controller:\w+>' => '<module>/api/<controller>/index',
				'<module:\w+>/<controller:\w+>/<action:\w+>' => '<module>/api/<controller>/<action>',
//                ['class' => 'yii\rest\UrlRule', 'controller' => 'app\modules\sms\controllers\api\brandname'],
			] 
		],
    ],
];


// Merge data config
$configs = array_replace_recursive(
    require(__DIR__ . '/common.php'),
    require(__DIR__ . '/modules.php'),
    require(__DIR__ . '/db.php'),
    require(__DIR__ . '/params.php'),
    $config,
    require(__DIR__ . '/local.php')
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
}

return $configs;
