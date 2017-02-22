<?php
$params = array_merge(
    require(__DIR__ . '/../../common/config/params.php'),
    require(__DIR__ . '/../../common/config/params-local.php'),
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);

return [
    'id' => 'app-backend',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log'],
    'modules' => [
        'gridview' => [
            'class' => '\kartik\grid\Module'
            // enter optional module parameters below - only if you need to
            // use your own export download action or custom translation
            // message source
            // 'downloadAction' => 'gridview/export/download',
            // 'i18n' => []
        ]
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
            'authTimeout' => 1800
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'class' => 'yii\web\Session',
            'name' => 'spa-backend',
            'timeout' => 3600 * 10,
            'useCookies' => true,
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
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
//        'assetManager'=>[
//            'linkAssets'=>true,
//        ],
        'urlManager' => [
//            'urlFormat'=>'path',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
//            'suffix'=>'.html',
            'rules' => [
            ],
        ],

//        'assetManager' => [
//            'bundles' => [
//                'all' => [
//                    'class' => 'yii\web\AssetBundle',
//                    'basePath' => '@webroot/assets',
//                    'baseUrl' => '@web/assets',
//                ],
//            ],
//        ],
    ],
    'params' => $params,
    'layout' => 'admin_layout',
];
