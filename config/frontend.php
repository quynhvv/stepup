<?php
$host = isset($_SERVER['SERVER_NAME']) ? $_SERVER['SERVER_NAME'] : '';
if ($host == 'let.vn') {
	$project = 'let';
} elseif (in_array($host, ['stepup.local', '70.39.250.20'])) {
	$project = 'stepup';
} else {
//	$project = 'bibomart_tuvan';
//	$project = 'bibomart_hoidap';
//	$project = 'bibomart_website';
//	$project = 'letvideo';
//	$project = 'letphim';
//	$project = 'stepup';
    $project = 'let';
//    $project = 'babymallcare';
}

if (isset($_GET['project']))
    $project = $_GET['project'];

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'language' => 'vi',
    'bootstrap' => ['log'],
    'defaultRoute' => 'common/frontend/default',
    'extensions' => require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\modules\account\models\User',
//            'loginUrl' => ['/account/frontend/auth/login'],
            'enableAutoLogin' => true,
        ],
        'errorHandler' => [
            'errorAction' => 'common/frontend/error',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
//        'assetManager' => [
//            'bundles' => [
//                'yii\web\JqueryAsset' => false
//            ],
//        ],
		'urlManager' => [ 
			'enablePrettyUrl' => true,
			'showScriptName' => false,
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
    require(__DIR__ . '/project/'.$project.'.php'),
    [
        'components' => [
            'urlManager' => [
                'rules' => [
                    // Global
                    'tag/<keyword>' => 'common/frontend/tag/index',

                    '<module:\w+>-<id:\w+>' => '<module>/frontend/detail/index',   
                    '<title>-<module:\w+>-<id:\w+>' => '<module>/frontend/detail/index',

                    '<module:\w+>/<controller:\w+>' => '<module>/frontend/<controller>/index',
                    '<module:\w+>/<controller:\w+>/<action>' => '<module>/frontend/<controller>/<action>',
                ] 

            ]
        ]
    ]
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
