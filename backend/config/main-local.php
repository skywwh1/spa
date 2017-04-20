<?php

$config = [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '5DCQ9VoU8YbrX2wyLtr8VAMF9sml-rYU',
        ],
    ],
//    'timeZone'=>'Etc/GMT-8',
];

if (!YII_ENV_TEST) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = [
        'class' => 'yii\debug\Module',
    ];

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = [
        'class' => 'yii\gii\Module',
        'allowedIPs' => ['192.168.56.*', 'YYY.YYY.YYY.YYY','XXX.XXX.XXX.XXX'],
    ];
}

return $config;
