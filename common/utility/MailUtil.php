<?php

/**
 * Created by PhpStorm.
 * User: Iven.Wu
 * Date: 2017-01-13
 * Time: 15:32
 */

namespace common\utility;

use common\models\Advertiser;
use common\models\Campaign;
use common\models\CampaignApiStatusLog;
use common\models\Channel;
use common\models\Deliver;
use common\models\LogAutoCheck;
use common\models\LogCheckClicksDaily;
use common\models\SendMailLog;
use common\models\User;
use Yii;

class MailUtil
{

    public static function sendCreateChannel(Channel $channel)
    {
        $mail = Yii::$app->mailer->compose('channel_created', ['channel' => $channel]);
        $mail->setTo($channel->email);
        if (isset($channel->om0)) {
            $mail->setCc($channel->om0->email);
        }
        $mail->setSubject('Welcome to SuperADS!');
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

    /**
     * @param LogAutoCheck[] $checks
     */
    public static function autoCheckCvr($checks)
    {
        $mail = Yii::$app->mailer->compose('auto_check', ['checks' => $checks]);
        $mail->setTo('operations@superads.cn');
        $mail->setSubject('Anticheat - SuperADS');
        $isSend = 0;
        if ($mail->send()) {
            $isSend = 1;
        }
        $param = array('type' => 'autoCheck', 'isSend' => $isSend);
        SendMailLog::saveMailLog($mail, $param);
        if ($isSend) {
            foreach ($checks as $check) {
                $check->is_send = 1;
                $check->save();
            }
        }
    }
    /*
    * @param Deliver $deliver
    * @return string
    */
    public static function updateGeo($deliver)
    {

        $channel = Channel::findIdentity($deliver->channel_id);
        $mail = Yii::$app->mailer->compose('updateGeo', ['deliver' => $deliver]);
        $mail->setTo($channel->email);
        $cc = array($channel->om0->email);
        if (!empty($channel->cc_email) && !empty(explode(';', $channel->cc_email))) {
            $cc = array_merge($cc, explode(';', $channel->cc_email));
        }
        $mail->setCc($cc);
        $mail->setSubject('Geo Update - SuperADS');
        $isSend = 0;
        if ($mail->send()) {
            $isSend = 1;
        }
        $param = array('type' => 'updateGeo', 'isSend' => $isSend);
        SendMailLog::saveMailLog($mail, $param);
        if ($isSend) {
            return true;
        } else {
            return false;
        }
    }

    /*
   * @param Deliver $deliver
   * @return string
   */
    public static function updateCreativeLink($deliver)
    {
        $channel = Channel::findIdentity($deliver->channel_id);
        $mail = Yii::$app->mailer->compose('update_creative_link', ['deliver' => $deliver]);
        $mail->setTo($channel->email);
        $cc = array($channel->om0->email);
        if (!empty($channel->cc_email) && !empty(explode(';', $channel->cc_email))) {
            $cc = array_merge($cc, explode(';', $channel->cc_email));
        }
        $mail->setCc($cc);
        $mail->setSubject('Creative Update - SuperADS');
        $isSend = 0;
        if ($mail->send()) {
            $isSend = 1;
        }
        $param = array('type' => 'update_creative_link', 'isSend' => $isSend);
        SendMailLog::saveMailLog($mail, $param);
        if ($isSend) {
            return true;
        } else {
            return false;
        }
    }
    /**
     * @param LogAutoCheck[] $checks
     */
    public static function autoCheckCap($checks)
    {
        $mail = Yii::$app->mailer->compose('over_cap', ['checks' => $checks]);
        $mail->setTo('operations@superads.cn');
        $mail->setSubject('Over Cap Alarm - SuperADS');
        $isSend = 0;
        if ($mail->send()) {
            $isSend = 1;
        }
        $param = array('type' => 'autoCheck', 'isSend' => $isSend);
        SendMailLog::saveMailLog($mail, $param);
        if ($isSend) {
            foreach ($checks as $check) {
                $check->is_send = 1;
                $check->save();
            }
        }
    }

    public static function sendGoodOffers($campaigns,$channel)
    {
//        $user_id = Yii::$app->user->id;
        $mail = Yii::$app->mailer->compose('good_campaign', ['campaigns' => $campaigns,'channel' =>$channel ]);
        $mail->setTo($channel->email);
//        if (isset($channel->om0)) {
//            $mail->setCc($channel->om0->email);
//        }

        $mail->setSubject('Good Offers Recommendation - SuperADS');
        $isSend = 0;
        if ($mail->send()) {
            $isSend = 1;
        }
        $param = array('type' => 'send good offers', 'isSend' => $isSend);
        SendMailLog::saveMailLog($mail, $param);
        if ($isSend) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $advertiser
     * @return bool
     */
    public static function numberConfirm($advertiser)
    {
        $mail = Yii::$app->mailer->compose('number_confirm', ['advertiser' => $advertiser]);
        $mail->setTo($advertiser->email);
        $cc = array($advertiser->bd0->email);
        if (!empty($advertiser->cc_email) && !empty(explode(';', $advertiser->cc_email))) {
            $cc = array_merge($cc, explode(';', $advertiser->cc_email));
        }
        $mail->setCc($cc);
        $mail->setSubject('Number Confirm - SuperADS');
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

    public static function sendQualityOffers($channel,$campaign,$subChannels,$dynamic_cols,$col_len,$date_range)
    {

//        $user_id = Yii::$app->user->id;
        $mail = Yii::$app->mailer->compose('channel_quality', ['channel' =>$channel,'campaign' => $campaign,
            'subChannels' =>$subChannels,'columnName' =>$dynamic_cols,'cols' => $col_len,'date_range' =>$date_range ]);
        $user_name = yii::$app->user->identity->username;
        $user = User::findOne(['username' => $user_name ]);
//        $mail->setTo($channel->email);
        $mail->setTo($user->email);
//        $mail->setTo($channel->email);
//        if (isset($channel->om0)) {
//            $mail->setCc($channel->om0->email);
//        }

        $mail->setSubject('Channel Quality Report- SuperADS');
        $isSend = 0;
        if ($mail->send()) {
            $isSend = 1;
        }
        $param = array('type' => 'send channel quality', 'isSend' => $isSend);
        SendMailLog::saveMailLog($mail, $param);
        if ($isSend) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $sts
     * @return bool
     */
    public static function pauseSubChannel($sts)
    {
        $channel = Channel::findIdentity($sts->channel_id);
        $mail = Yii::$app->mailer->compose('pause_sub_channel', ['sub_log' => $sts]);
        $mail->setTo($channel->email);
        $cc = array($channel->om0->email);
        if (!empty($channel->cc_email) && !empty(explode(';', $channel->cc_email))) {
            $cc = array_merge($cc, explode(';', $channel->cc_email));
        }
        $mail->setCc($cc);
        $mail->setSubject('Pausing Sub Publisher - SuperADS');
        $isSend = 0;
        if ($mail->send()) {
            $isSend = 1;
        }
        $param = array('type' => 'pause sub publisher', 'isSend' => $isSend);
        SendMailLog::saveMailLog($mail, $param);
        if ($isSend) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param LogCheckClicksDaily[] $checks
     */
    public static function checkClicks($checks)
    {
        $mail = Yii::$app->mailer->compose('check_clicks', ['checks' => $checks]);
        $mail->setTo('operations@superads.cn');
        $mail->setSubject('Low CR Anticheat - SuperADS');
        $mail->send();
    }

    /**
     * @param LogAutoCheck[] $checks
     */
    public static function autoCheckSubCvr($checks)
    {
        $mail = Yii::$app->mailer->compose('auto_check_sub', ['checks' => $checks]);

        $mail->setTo('operations@superads.cn');
        $mail->setSubject('Sub Chid Anticheat - SuperADS');
        $isSend = 0;
        if ($mail->send()) {
            $isSend = 1;
        }
        $param = array('type' => 'autoCheckSub', 'isSend' => $isSend);
        SendMailLog::saveMailLog($mail, $param);
        if ($isSend) {
            foreach ($checks as $check) {
                $check->is_send = 1;
                $check->save();
            }
        }
    }

    /**
     * @param LogAutoCheck[] $checks
     */
    public static function autoCheckLowMargin($checks)
    {
        $mail = Yii::$app->mailer->compose('auto_check_low_margin', ['checks' => $checks]);

        $mail->setTo('operations@superads.cn');
        $mail->setSubject(' Low Margin Notice - SuperADS');
        $isSend = 0;
        if ($mail->send()) {
            $isSend = 1;
        }
        $param = array('type' => 'autoCheckLowMargin', 'isSend' => $isSend);
        SendMailLog::saveMailLog($mail, $param);
        if ($isSend) {
            foreach ($checks as $check) {
                $check->is_send = 1;
                $check->save();
            }
        }
    }

    public static function sendMailFromBackend($channel,$campaign,$content)
    {
        $mail= Yii::$app->mailer->compose();
        $mail->setHtmlBody($content);    //发布可以带html标签的文本
//        $mail->setTo('2539131080@qq.com');
        $mail->setTo($channel->email);
        if (isset($channel->om0)) {
            $mail->setCc($channel->om0->email);
        }
        $mail->setSubject('SuperADS '.$campaign->id.' '.$campaign->campaign_name);
        $isSend = 0;
        if ($mail->send()) {
            $isSend = 1;
        }
        $param = array('type' => 'from backend', 'isSend' => $isSend);
        SendMailLog::saveMailLog($mail, $param);
    }


    public static function sendChannelInfo($channel)
    {
        $mail = Yii::$app->mailer->compose('channel_info', ['channel' => $channel]);
        $mail->setTo($channel->email);
        if (isset($channel->om0)) {
            $mail->setCc($channel->om0->email);
        }
        $mail->setSubject('[SuperADS] account create success!');
        $isSend = 0;
        if ($mail->send()) {
            $isSend = 1;
        }
        $param = array('type' => 'channel info', 'isSend' => $isSend);
        SendMailLog::saveMailLog($mail, $param);
    }

    /**
     * @param CampaignApiStatusLog[] $checks
     */
    public static function autoCheckApiPause($checks)
    {
        echo count($checks);
        $mail = Yii::$app->mailer->compose('api_paused', ['checks' => $checks]);
        $mail->setTo('operations@superads.cn');
//        $mail->setTo('iven.wu@superads.cn');
        $mail->setSubject('Api campaign paused - SuperADS');
        $mail->send();
    }

    public static function sendPayableConfirm($campaignBills)
    {
        $mail = Yii::$app->mailer->compose('payable_confirm', ['campaignBills' =>$campaignBills]);
        $user_name = yii::$app->user->identity->username;
        $user = User::findOne(['username' => $user_name ]);
        $mail->setTo($user->email);

        $mail->setSubject('SuperADS Confirmed Numbers');
        $isSend = 0;
        if ($mail->send()) {
            $isSend = 1;
        }
        $param = array('type' => 'send  confirmed numbers', 'isSend' => $isSend);
        SendMailLog::saveMailLog($mail, $param);
        if ($isSend) {
            return true;
        } else {
            return false;
        }
    }

    public static function sendOverReachEighty($checks)
    {
        $mail = Yii::$app->mailer->compose('over_reach', ['checks' => $checks]);
//        $mail->setTo('operations@superads.cn');
        $mail->setTo('2539131080@qq.com');
        $mail->setSubject('Reach 80% Daily Cap - SuperADS');
        $isSend = 0;
        if ($mail->send()) {
            $isSend = 1;
        }
        $param = array('type' => 'autoCheck', 'isSend' => $isSend);
        SendMailLog::saveMailLog($mail, $param);
        if ($isSend) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * @param $campaigns
     * @param $user
     * @param $type
     * @return bool
     */
    public static function sendSelectUpdateOffers($campaigns, $user,$type)
    {
//        $user_id = Yii::$app->user->id;
        if ($type == 1){
            $mail = Yii::$app->mailer->compose('select_pause_campaign', ['campaigns' => $campaigns]);
            $mail->setSubject('Pausing Offers - SuperADS');
        } else if ($type == 2){
            $mail = Yii::$app->mailer->compose('select_price_campaign', ['campaigns' => $campaigns]);
            $mail->setSubject('PriceUpdate Offers - SuperADS');
        } else{
            $mail = Yii::$app->mailer->compose('select_service_campaign', ['campaigns' => $campaigns]);
            $mail->setSubject('Service Offers - SuperADS');
        }

        $mail->setTo($user->email);
//        $mail->setTo('2539131080@qq.com');

        $isSend = 0;
        if ($mail->send()) {
            $isSend = 1;
        }
        $param = array('type' => 'send select pausing offers', 'isSend' => $isSend);
        SendMailLog::saveMailLog($mail, $param);
        if ($isSend) {
            return true;
        } else {
            return false;
        }
    }


}