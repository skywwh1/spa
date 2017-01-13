<?php

/**
 * Created by PhpStorm.
 * User: Iven.Wu
 * Date: 2017-01-13
 * Time: 15:32
 */
namespace common\utility;
use common\models\Channel;

class MailUtil
{

    public static function pppp()
    {
        return 'adsf';
    }

    public static function sendCreateChannel(Channel $channel)
    {
//                echo "aaa";
//        $mail = \Yii::$app->mailer->compose()
//            ->setTo($channel->email)
//            ->setSubject('邮件发送配置')
//            //->setTextBody('Yii中文网教程真好 www.yii-china.com')   //发布纯文字文本
//            ->setHtmlBody("<br>Yii中文网教程真好！www.yii-china.com")//发布可以带html标签的文本
//            ->send();
//        if ($mail)
//            echo 'success';
//        else
//            echo 'fail';
//        echo "kk";
//        die();

        //                echo "aaa";
        $mail = \Yii::$app->mailer->compose('channel_created',['channel'=>$channel])
            ->setTo($channel->email)
            ->setSubject('邮件发送配置')
            //->setTextBody('Yii中文网教程真好 www.yii-china.com')   //发布纯文字文本
//            ->setHtmlBody("<br>Yii中文网教程真好！www.yii-china.com")//发布可以带html标签的文本
            ->send();
        if ($mail)
            echo 'success';
        else
            echo 'fail';
        echo "kk";
        die();
    }
}