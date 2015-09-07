<?php
$theme = 'stepup';
return [
    'name' => 'StepupCareers',
    'language' => 'en',
    'components' => [
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => [
//                'google' => [
//                    'class' => 'yii\authclient\clients\GoogleOpenId',
//                    'title' => ''
//                ],
                'facebook' => [
                    'class' => 'yii\authclient\clients\Facebook',
                    'clientId' => '1456753344629325',
                    'clientSecret' => '50cfbd816d12bd9a62269cabbc7e7028',
                    'title' => 'Facebook Sign In',
                    'viewOptions' => ['popupWidth' => "800", 'popupHeight' => "500",]
                ],
            ],
        ],
        'view' => [
            'theme' => [
                'pathMap' => [
                    '@app/views' => '@app/themes/' . $theme . '/views',
                    '@app/modules' => '@app/themes/' . $theme . '/modules',
                    '@app/widgets' => '@app/themes/' . $theme . '/widgets',
                ],
                'basePath' => '@app/themes/' . $theme,
                'baseUrl' => '@web/themes/' . $theme,
            ],
        ],
    ],
];
