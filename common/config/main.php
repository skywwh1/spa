<?php
Yii::$classMap['JsonUtil'] = '@common/models/utility/JsonUtil.php';
Yii::$classMap['ModelsUtil'] = '@common/models/utility/ModelsUtil.php';
return [
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
//            'class' => 'yii\caching\ApcCache',
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager',
        ],
    ],
];
