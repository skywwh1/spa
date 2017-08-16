<?php

namespace console\controllers;

use common\models\Campaign;
use common\models\CampaignCreativeLink;
use common\models\CampaignLogHourly;
use common\models\CampaignStsUpdate;
use common\models\Channel;
use common\models\Deliver;
use common\models\LogAutoCheck;
use common\models\LogClick;
use common\models\LogClick2;
use common\models\LogFeed;
use common\models\LogPost;
use common\models\RedirectLog;
use common\utility\MailUtil;
use yii\console\Controller;

/**
 * Created by PhpStorm.
 * User: wh wu
 * Date: 1/15/2017
 * Time: 3:39 PM
 */
class CampaignController extends Controller
{

    public function actionUpdate()
    {
        //1 campaign update
//        $update = CampaignStsUpdate::findOne();
        // 2 sts update
        // 更新sts paused
        $delivers = Deliver::getNeedPause();

        if (isset($delivers)) {
            foreach ($delivers as $item) {
                $item->status = 2;
                $item->is_manual = 1; //手动停单
                $this->echoMessage('sts paused ' . $item->campaign_uuid . '-' . $item->channel_id);
                $item->save();
                $redirect = RedirectLog::findLastRedirect($item->campaign_id,$item->channel_id);
                if (!empty($redirect)){
                    $redirect->status = 2;
                    $redirect->save();
                }
                var_dump($item->getErrors());
            }
        }

        $camps = Campaign::getNeedPause();
        if (isset($camps)) {
            foreach ($camps as $item) {
                $item->status = 2;
                $this->echoMessage('campaign paused ' . $item->campaign_uuid);
                if ($item->save()) {
                    $delivers = Deliver::findRunningByCampaignId($item->id);
                    if (isset($delivers)) {
                        foreach ($delivers as $sts) {
                            $sts->status = 2;
                            $this->echoMessage('sts paused ' . $item->campaign_uuid . '-' . $sts->channel_id);
                            if (!$sts->save()){
                                var_dump($sts->getErrors());
                            }else{
                                $redirect = RedirectLog::findLastRedirect($sts->campaign_id,$sts->channel_id);
                                if(!empty($redirect)){
                                    $redirect->status = 2;
                                    $redirect->save();
                                }
                            }
                        }
                    }
                } else {
                    var_dump($item->getErrors());
                }
            }
        }


        // 更新sts daily cap
        $updateCaps = CampaignStsUpdate::getStsUpdateCap();
        if (isset($updateCaps)) {
            foreach ($updateCaps as $item) {
                $deliver = Deliver::findIdentity($item->campaign_id, $item->channel_id);
                if (isset($deliver)) {
                    $deliver->daily_cap = (int)$item->value;
                    $deliver->save();
                }
                $item->is_effected = 1;
                $item->save();
            }
        }

        $updatePayout = CampaignStsUpdate::getStsUpdatePay();
        if (isset($updatePayout)) {
            foreach ($updatePayout as $item) {
                $deliver = Deliver::findIdentity($item->campaign_id, $item->channel_id);
                if (isset($deliver)) {
                    $deliver->pay_out = $item->value;
                    $deliver->save();
                }
                $item->is_effected = 1;
                $item->save();
            }
        }

        $updateGeo = CampaignStsUpdate::getStsUpdateGeo();
        if (isset($updateGeo)) {
            foreach ($updateGeo as $item) {
                $camp = Campaign::findOne($item->campaign_id);
                if (isset($camp)) {
                    $this->echoMessage('campaign update geo ' . $item->campaign_id);
                    $camp->target_geo = $item->value;
                    $camp->save();
                }
                $item->is_effected = 1;
                $item->save();
            }
        }

        $updateLinks = CampaignStsUpdate::getStsUpdateCreativeLink();
        if (isset($updateLinks)) {
            foreach ($updateLinks as $item) {
                $camp = Campaign::findOne($item->campaign_id);
                $old_creative_link = CampaignCreativeLink::getCampaignCreativeLinksById($item->campaign_id);
                $new_creative_link = json_decode($item->value);
                if (!empty($new_creative_link)) {
                    $flag = CampaignCreativeLink::updateCreativeLinks($old_creative_link, $new_creative_link, $item->campaign_id);
                    if ($flag) {
                        $this->echoMessage('campaign update creative link ' . $item->campaign_id);
                        $item->is_effected = 1;
                        $item->save();
                    }
                }
            }
        }

        $restart = CampaignStsUpdate::getStsRestart();
        if(!empty($restart)){
            foreach ($restart as $item) {
                $deliver = Deliver::findIdentity($item->campaign_id, $item->channel_id);
                if (isset($deliver)) {
                    $deliver->status = 1;
                    $deliver->save();
                }
                $item->is_effected = 1;
                $item->save();
            }
        }

        $updatePrice = CampaignStsUpdate::getStsUpdatePrice();
        if (isset($updatePrice)) {
            foreach ($updatePrice as $item) {
                $camp = Campaign::findOne($item->campaign_id);
                if (isset($camp)) {
                    $this->echoMessage('campaign update price ' . $item->campaign_id);
                    $camp->adv_price = $item->value;
                    $camp->save();
                }
                $item->is_effected = 1;
                $item->save();
            }
        }

        $updatePayout = CampaignStsUpdate::getStsUpdatePayout();
        if (isset($updatePayout)) {
            foreach ($updatePayout as $item) {
                $camp = Campaign::findOne($item->campaign_id);
                if (isset($camp)) {
                    $this->echoMessage('campaign update payout ' . $item->campaign_id);
                    $camp->now_payout = $item->value;
                    $camp->save();
                }
                $item->is_effected = 1;
                $item->save();
            }
        }

        $camps = RedirectLog::findAllActive();
        if (isset($camps)) {
            foreach ($camps as $item) {
                $item->status = 2;
                $this->echoMessage('S2S redirect ' . $item->campaign_id.$item->channel_id);
                $delivers = Deliver::getPausedCampaign($item->campaign_id,$item->channel_id);
                if (isset($delivers)) {
                    $item->save();
                }
            }
        }
    }

    public function actionSendUpdate()
    {
        $pause = array();
        $cap = array();
        $payout = array();
        $updateGeo = array();
        $updateCreativeLink = array();
        $models = CampaignStsUpdate::getStsSendMail();
        if (isset($models)) {
            foreach ($models as $item) {
                if ($item->type === 1) { // campaign 群发
                    $camp = Campaign::findById($item->campaign_id);
                    $this->echoMessage($item->name);
                    if (isset($camp)) {
                        $delivers = Deliver::findRunningByCampaignId($camp->id);
                        if ($item->name == 'pause') {
                            foreach ($delivers as $d) {
                                $d->effect_time = $item->effect_time;
                                $pause[$camp->id][] = $d;
                            }
                        } else if ($item->name == 'cap') {
                            foreach ($delivers as $d) {
                                $d->newValue = $item->value;
                                $cap[$camp->id][] = $d;
                            }
                        } else if ($item->name == 'payout') {
                            foreach ($delivers as $d) {
                                $d->newValue = $item->value;
                                $d->effect_time = $item->effect_time;
                                $payout[$camp->id][] = $d;
                            }
                        } else if ($item->name == 'update-geo') {
                            foreach ($delivers as $d) {
                                $d->oldValue = $item->old_value;
                                $d->newValue = $item->value;
                                $d->effect_time = $item->effect_time;
                                $d->target_geo = $item->target_geo;
                                $updateGeo[$camp->id][] = $d;
                            }
                        } else if ($item->name == 'update-creative') {
                            foreach ($delivers as $d) {
                                $d->oldValue = $item->old_value;
                                $new_links = json_decode($item->value);
                                $str = array();
                                foreach ($new_links as $link) {
                                    $creative_type = CampaignCreativeLink::getCreativeLinkValue($link->creative_type);
                                    if (!empty($link->creative_type) && !empty($link->creative_link)) {
                                        array_push($str, $creative_type . ':' . $link->creative_link);
                                    }
                                }
                                $d->newValue = implode(";", $str);
                                $d->effect_time = $item->effect_time;
                                $d->creative_link = $item->creative_link;
                                $updateCreativeLink[$camp->id][] = $d;
                            }
                        }
                    }

                } else if ($item->type == 2) {  //单独发
                    $sts = Deliver::findIdentity($item->campaign_id, $item->channel_id);
                    if (isset($sts)) {
                        if ($item->name == 'pause') {
                            $sts->effect_time = $item->effect_time;
                            $pause[$item->campaign_id][] = $sts;
                        } else if ($item->name == 'cap') {
                            $sts->newValue = $item->value;
                            $cap[$item->campaign_id][] = $sts;
                        } else if ($item->name == 'payout') {
                            $sts->newValue = $item->value;
                            $sts->effect_time = $item->effect_time;
                            $payout[$item->campaign_id][] = $sts;
                        }
                    }
                }
            }
        }
        // 每一个都是 [campaign_id][delivers]
        if (!empty($payout)) {
            $this->echoMessage('update payout');
            foreach ($payout as $campaign_id => $delivers) {
                $this->echoMessage('Campaign id : ' . $campaign_id);
                if (isset($delivers)) {
                    foreach ($delivers as $item) {
                        if (MailUtil::payoutUpdate($item)) {
                            $this->echoMessage($item->channel_id . ' send success');
                        } else {
                            $this->echoMessage($item->channel_id . ' send fail');
                        }
                        $this->echoMessage("waiting 1s");
                        sleep(1);
                    }
                }
            }
        }

        if (!empty($cap)) {
            $this->echoMessage('update cap');
            foreach ($cap as $campaign_id => $delivers) {
                $this->echoMessage('Campaign id : ' . $campaign_id);
                if (isset($delivers)) {
                    foreach ($delivers as $item) {
                        if (MailUtil::capUpdate($item)) {
                            $this->echoMessage($item->channel_id . ' send success');
                        } else {
                            $this->echoMessage($item->channel_id . ' send fail');
                        }
                        $this->echoMessage("waiting 1s");
                        sleep(1);
                    }
                }
            }
        }

        if (!empty($pause)) {
            $this->echoMessage('Paused start');
            foreach ($pause as $campaign_id => $delivers) {
                if (isset($delivers)) {
                    foreach ($delivers as $item) {
                        if (MailUtil::paused($item)) {
                            $this->echoMessage($item->channel_id . ' send success');
                        } else {
                            $this->echoMessage($item->channel_id . ' send fail');
                        }
                        $this->echoMessage("waiting 1s");
                        sleep(1);
                    }
                }
            }
        }

        if (!empty($updateGeo)) {
            $this->echoMessage('UpdateGeo start');
            foreach ($updateGeo as $campaign_id => $delivers) {
                if (isset($delivers)) {
                    foreach ($delivers as $item) {
                        if (MailUtil::updateGeo($item)) {
                            $this->echoMessage($item->channel_id . ' send success');
                        } else {
                            $this->echoMessage($item->channel_id . ' send fail');
                        }
                        $this->echoMessage("waiting 1s");
                        sleep(1);
                    }
                }
            }
        }

        if (!empty($updateCreativeLink)) {
            $this->echoMessage('Update Creative Link start');
            foreach ($updateCreativeLink as $campaign_id => $delivers) {
                if (isset($delivers)) {
                    foreach ($delivers as $item) {
                        if (MailUtil::updateCreativeLink($item)) {
                            $this->echoMessage($item->channel_id . ' send success');
                        } else {
                            $this->echoMessage($item->channel_id . ' send fail');
                        }
                        $this->echoMessage("waiting 1s");
                        sleep(1);
                    }
                }
            }
        }

        if (isset($models)) {
            foreach ($models as $item) {
                $item->is_send = 2;
                $item->save();
            }
        }
    }

    private function echoMessage($str)
    {
        echo " \t $str \n";
    }

    /**
     * 给渠道postback
     * @param $click_uuid
     */
    public function actionPost($click_uuid)
    {
        $logFeed = LogFeed::findOne(['click_uuid' => $click_uuid]);
        $logClick = LogClick::findByClickUuid($click_uuid);
        if (empty($logClick)) {
            $logClick = LogClick2::findByClickUuid($click_uuid);
        }
        if (empty($logClick)) {
            $this->echoMessage('can`t found click_uuid');
        }
        $sts = Deliver::findIdentity($logClick->campaign_id, $logClick->channel_id);
        $post = new LogPost();
        $post->click_uuid = $logFeed->click_uuid;
        $post->click_id = $logFeed->click_id;
        $post->channel_id = $logFeed->channel_id;
        $post->campaign_id = $logFeed->campaign_id;
        $post->pay_out = $logClick->pay_out;
        $post->discount = $logClick->discount;
        $post->daily_cap = $logClick->daily_cap;
        $post->ch_subid = empty($logClick->ch_subid) ? '0' : $logClick->ch_subid;
        $post->post_link = $this->genPostLink($sts->channel->post_back, $logClick->all_parameters);
        //* 0:need to post, 1.posted
        $post->post_status = 0;
        if ($post->save() == false) {
            $this->echoMessage('save log post error');
            var_dump($post->getErrors());
        } else {
            $this->echoMessage('save success ' . $click_uuid);
        }
    }

    private function genPostLink($postback, $allParams)
    {
        if (!empty($allParams)) {
            $params = explode('&', $allParams);
            foreach ($params as $item) {
                $param = explode('=', $item);
                $k = '{' . $param[0] . '}';
                $v = $param[1];
                $postback = str_replace($k, $v, $postback);
            }
        }

        $this->echoMessage("generate url: " . $postback);
        return $postback;
    }

    /**
     * 针对：Level =A, Create Type=API 的渠道
        如果这些渠道昨日跑的单子 match cvr > 0.3%, 这个单子的总体cap（所有渠道加和）还未跑满（Match install < 80% daily cap)，
     * 则系统自动创建一个一摸一样的单子（只有UUID不一样），且系统自动给这个渠道S2S
       注意：创建克隆单之后，第二天再判断是否超总体cap 需要算原单+克隆单 的总match install 与原单子 80% daily cap 的比值。
       当原单+克隆单 的总match install > 80% cap 时，邮件提醒该单子的BD+PM
     */
    public  function actionCreateCampaignAuto(){
        $start =  mktime(0,0,0,date('m'),date('d')-10,date('Y'));
        $end =  mktime(0,0,0,date('m'),date('d'),date('Y'));
        $delivers = Deliver::find()->joinWith(['channel c'])
             ->andFilterWhere(['campaign_channel_log.status' => 1])
             ->andFilterWhere(['c.level' => 1,'c.create_type' => 1])
             ->all();

        /**
         * 如果这些渠道昨日跑的单子 match cvr > 0.3%, 这个单子的总体cap（所有渠道加和）还未跑满（Match install < 80% daily cap)，
         * 则系统自动创建一个一摸一样的单子（只有UUID不一样），且系统自动给这个渠道S2S
         * */
        $checks = [];
        foreach ($delivers as $item){
            $log = CampaignLogHourly::findDateReport($start, $end, $item->campaign_id,$item->channel_id);
            if ($log['clicks'] == 0) {
                continue;
            }
            $cvr = ($log['match_installs'] / $log['clicks']) * 100;
            if ($cvr > 0.3) {
                $this->echoMessage("cvr>0.3 : " . $item->campaign_id.'-'.$item->channel_id);
                $camp_logs = CampaignLogHourly::findDateReportByCamp($start, $end, $item->campaign_id);
                if ($camp_logs->daily_cap>0){
                    $mc = ($camp_logs->match_installs/$camp_logs->daily_cap)*100;
                    if ($mc <= 80){
                        $this->echoMessage("install/daily_cap <= 80% : " . $item->campaign_id.'-'.$item->channel_id);
                        $old_camp = Campaign::findOne($item->campaign_id);
                        $new_camp = clone $old_camp;
                        $new_camp->campaign_uuid = $item->campaign->advertiser.'_'.time();
                        $new_camp->isNewRecord = true;
                        $new_camp->id = null;
                        $new_camp->save();

                        $deliver = new Deliver();
                        $deliver->campaign_id = $new_camp->id;
                        $deliver->channel_id = $item->channel_id;
                        $deliver->campaign_uuid = isset($deliver->campaign) ? $deliver->campaign->campaign_uuid : "";
                        $deliver->channel0 = isset($deliver->channel) ? $deliver->channel->username : '';
                        $deliver->adv_price = isset($deliver->campaign) ? $deliver->campaign->adv_price : 0;
                        if($deliver->channel->pay_out == 1){
                            $deliver->pay_out = isset($deliver->campaign) ? $deliver->campaign->adv_price : 0;
                        }else{
                            $deliver->pay_out = isset($deliver->campaign) ? $deliver->campaign->now_payout : 0;
                        }
                        if(empty($deliver->channel->daily_cap)){
                            $deliver->daily_cap = isset($deliver->campaign) ? $deliver->campaign->daily_cap : 0;
                        }else{
                            $deliver->daily_cap =$deliver->channel->daily_cap;
                        }
                        $deliver->kpi = isset($deliver->campaign) ? $deliver->campaign->kpi : '';
                        $deliver->note = isset($deliver->campaign) ? $deliver->campaign->note : '';
                        $deliver->others = isset($deliver->campaign) ? $deliver->campaign->others : '';
                        $deliver->discount = isset($deliver->channel) ? $deliver->channel->discount : 30;
                        $deliver->save();
                    }else {
                        $this->echoMessage("install/daily_cap >= 80% : " . $item->campaign_id.'-'.$item->channel_id);
                        $check = new LogAutoCheck();
                        $check->campaign_id = $item->campaign_id;
                        $check->channel_id = $item->channel_id;
                        $check->campaign_name = $item->campaign->campaign_name;
                        $check->channel_name = $item->channel->username;
                        $check->match_cvr = $cvr;
                        $check->match_install = $log->match_installs;
                        $check->type = 1;
                        $checks[] = $check;
                    }
                }
            }
        }

        if (!empty($checks)) {
            MailUtil::sendOverReachEighty($checks);
        }
    }
}