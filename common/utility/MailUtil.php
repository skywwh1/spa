<?php

/**
 * Created by PhpStorm.
 * User: Iven.Wu
 * Date: 2017-01-13
 * Time: 15:32
 */
namespace common\utility;

use common\models\Channel;
use common\models\Deliver;
use common\models\SendMailLog;
use Yii;

class MailUtil
{

    public static function sendCreateChannel(Channel $channel)
    {
        $mail = Yii::$app->mailer->compose('channel_created', ['channel' => $channel]);
        $mail->setTo($channel->email);
        $mail->setSubject('SuperADS account create success');
        $isSend = 0;
        if ($mail->send()) {
            $isSend = 1;
        }
        $param = array('type' => 'channel create', 'isSend' => $isSend);
        SendMailLog::saveMailLog($mail, $param);
    }

    public static function sendSTSCreateMail(Deliver $deliver)
    {
        $mail = Yii::$app->mailer->compose('sts_created', ['deliver' => $deliver]);
        $mail->setTo($deliver->channel->email);
        $mail->setSubject('SuperADS New Campaign');
        $isSend = 0;
        if ($mail->send()) {
            $isSend = 1;
        }
        $param = array('type' => 's2s create', 'isSend' => $isSend);
        SendMailLog::saveMailLog($mail, $param);
    }
}