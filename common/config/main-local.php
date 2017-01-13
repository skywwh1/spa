<?php
return [
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=localhost;dbname=spa',
            'username' => 'root',
            'password' => 'root',
            'charset' => 'utf8',
        ],
//        'mailer' => [
//            'class' => 'yii\swiftmailer\Mailer',
//            'viewPath' => '@common/mail',
//            // send all mails to a file by default. You have to set
//            // 'useFileTransport' to false and configure a transport
//            // for the mailer to send real emails.
//            'useFileTransport' => true,
//        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            'useFileTransport' => false,    //这里一定要改成false，不然邮件不会发送
            'transport' => [
                'class' => 'Swift_SmtpTransport',
//                'host' => 'smtp.126.com',
//                'username' => 'skywwh1@126.com',
//                'password' => 'wwh123456',        //如果是163邮箱，此处要填授权码
//                'port' => '25',
//                'encryption' => 'tls',
                'host' => 'smtp.mxhichina.com',
                'username' => 'admin@superads.cn',
                'password' => 'Asdf1234!@',        //如果是163邮箱，此处要填授权码
                'port' => '25',
                'encryption' => 'tls',

            ],
            'messageConfig'=>[
                'charset'=>'UTF-8',
                'from'=>['admin@superads.cn'=>'SuperAds Admin']
            ],
        ],
    ],
];
