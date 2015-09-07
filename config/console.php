<?php
$config = [
    'id' => 'basic-console',
    'basePath' => dirname(__DIR__),
// 	'language' => 'vi',
    'bootstrap' => ['log'],
    'controllerNamespace' => 'app\commands',
    'extensions' => require(__DIR__ . '/../vendor/yiisoft/extensions.php'),
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'log' => [
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'useFileTransport' => false,
            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.gmail.com',
                'username' => 'sendmail0193@gmail.com',
                'password' => 'locdinhky',
                'port' => '465',
                'encryption' => 'ssl',
//                'plugins' => [
//                    [
//                        'class' => 'Swift_Plugins_LoggerPlugin',
//                        'constructArgs' => [new Swift_Plugins_Loggers_EchoLogger],
//                    ],
//                ],
            ],
        ],
    	'urlManager' => [
    		'baseUrl' => 'http://localhost/letyii/cms/',
    		'scriptUrl' => '',
    	]
    ],
];


// Merge data config
$configs = array_replace_recursive(
// 		require(__DIR__ . '/common.php'),
		require(__DIR__ . '/modules.php'),
		require(__DIR__ . '/db.php'),
		require(__DIR__ . '/params.php'),
		$config
// 		require(__DIR__ . '/local.php')
);

return $configs;
