<?php

return [
    'timeZone' => 'Asia/Ho_Chi_Minh',
    'components' => [
        'errorHandler' => [
            'maxSourceLines' => 20,
        ],
        'request' => [
            'enableCookieValidation' => true,
            'enableCsrfValidation' => false,
            'cookieValidationKey' => 'letyii@!$(!&@',
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'suffix' => '.html',

        ],
        'authManager' => [
            'class' => 'app\components\MongodbManager',
            'god_id' => 'yPgZuneO',
        ],
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '205949952886967',
                    'clientSecret' => 'bfc0c11ada1ab56ec57f459ce3d06b63',
                    'title' => '',
                    'viewOptions' => [
                        'popupWidth' => 800,
                        'popupHeight' => 500
                    ]
                ],
            ],
        ],
        'imageCache' => [
            'class' => 'letyii\imagecache\imageCache',
            'cachePath' => '@app/uploads/cache',
            'cacheUrl' => '@web/uploads/cache',
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
                'plugins' => [
                    [
                        'class' => 'Swift_Plugins_LoggerPlugin',
                        'constructArgs' => [new Swift_Plugins_Loggers_EchoLogger],
                    ],
                ],
            ],
        ],
        'assetManager' => [
            'bundles' => [
                'yii\web\JqueryAsset' => [
                    'js' => [
                        'jquery.min.js',
                    ]
                ],
                'yii\bootstrap\BootstrapAsset' => [
                    'css' => [
                        'css/bootstrap.min.css',
                    ],
                ],
                'yii\bootstrap\BootstrapPluginAsset' => [
                    'js' => [
                        'js/bootstrap.min.js',
                    ],
                ],
            ],
        ],
    ],
];