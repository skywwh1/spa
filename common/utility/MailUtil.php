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
        if(isset( $channel->om0)){
            $mail->setCc($channel->om0->email);
        }
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

    /**
     * @param Channel $channel
     * @param Deliver[] $delivers
     * @return string
     */
    public static function sendStsChannelMail($channel, $delivers)
    {
        $mail = Yii::$app->mailer->compose('sts_channel_created', ['delivers' => $delivers, 'channel' => $channel]);
        $mail->setTo($channel->email);
        $cc = array($channel->om0->email);
        if (!empty($channel->cc_email) && !empty(explode(';', $channel->cc_email))) {
            $cc = array_merge($cc, explode(';', $channel->cc_email));
        }
        $mail->setCc($cc);
        $mail->setSubject('New Offers from SuperADS');
        $isSend = 0;
        if ($mail->send()) {
            foreach ($delivers as $deliver) {
                $deliver->is_send_create = 1;
                $deliver->save();
            }
            $isSend = 1;
        }
        $param = array('type' => 's2s create', 'isSend' => $isSend);
        SendMailLog::saveMailLog($mail, $param);
        if ($isSend) {
            return "Channel " . $channel->id . ' send success!';
        } else {
            return "Channel " . $channel->id . ' send Fail!';
        }
    }


    /**
     * @param Deliver $deliver
     * @return string
     */
    public static function capUpdate($deliver)
    {
        $channel = Channel::findIdentity($deliver->channel_id);
        $mail = Yii::$app->mailer->compose('update_cap', ['deliver' => $deliver]);
        $mail->setTo($channel->email);
        $cc = array($channel->om0->email);
        if (!empty($channel->cc_email) && !empty(explode(';', $channel->cc_email))) {
            $cc = array_merge($cc, explode(';', $channel->cc_email));
        }
        $mail->setCc($cc);
        $mail->setSubject('Cap Update - SuperADS');
        $isSend = 0;
        if ($mail->send()) {
            $isSend = 1;
        }
        $param = array('type' => 'cap update', 'isSend' => $isSend);
        SendMailLog::saveMailLog($mail, $param);
        if ($isSend) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param Deliver $deliver
     * @return string
     */
    public static function payoutUpdate($deliver)
    {

        $channel = Channel::findIdentity($deliver->channel_id);
        $mail = Yii::$app->mailer->compose('update_payout', ['deliver' => $deliver]);
        $mail->setTo($channel->email);
        $cc = array($channel->om0->email);
        if (!empty($channel->cc_email) && !empty(explode(';', $channel->cc_email))) {
            $cc = array_merge($cc, explode(';', $channel->cc_email));
        }
        $mail->setCc($cc);
        $mail->setSubject('Payout Update - SuperADS');
        $isSend = 0;
        if ($mail->send()) {
            $isSend = 1;
        }
        $param = array('type' => 'update_payout', 'isSend' => $isSend);
        SendMailLog::saveMailLog($mail, $param);
        if ($isSend) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param Deliver $deliver
     * @return string
     */
    public static function paused($deliver)
    {

        $channel = Channel::findIdentity($deliver->channel_id);
        $mail = Yii::$app->mailer->compose('pause', ['deliver' => $deliver]);
        $mail->setTo($channel->email);
        $cc = array($channel->om0->email);
        if (!empty($channel->cc_email) && !empty(explode(';', $channel->cc_email))) {
            $cc = array_merge($cc, explode(';', $channel->cc_email));
        }
        $mail->setCc($cc);
        $mail->setSubject('Pausing Campaign - SuperADS');
        $isSend = 0;
        if ($mail->send()) {
            $isSend = 1;
        }
        $param = array('type' => 'pause', 'isSend' => $isSend);
        SendMailLog::saveMailLog($mail, $param);
        if ($isSend) {
            return true;
        } else {
            return false;
        }
    }
}