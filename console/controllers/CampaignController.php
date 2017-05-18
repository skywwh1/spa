<?php
namespace console\controllers;

use common\models\Campaign;
use common\models\CampaignCreativeLink;
use common\models\CampaignStsUpdate;
use common\models\Deliver;
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
                            if (!$sts->save())
                                var_dump($sts->getErrors());
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
                    $camp ->target_geo = $item->value;
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
                if(!empty($new_creative_link)){
                    $flag = CampaignCreativeLink::updateCreativeLinks($old_creative_link,$new_creative_link,$item->campaign_id);
                    if($flag){
                        $this->echoMessage('campaign update creative link ' . $item->campaign_id);
                        $item->is_effected = 1;
                        $item->save();
                    }
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
                        }else if ($item->name == 'update-geo') {
                            foreach ($delivers as $d) {
                                $d->oldValue = $item->old_value;
                                $d->newValue = $item->value;
                                $d->effect_time = $item->effect_time;
                                $d->target_geo = $item->target_geo;
                                $updateGeo[$camp->id][] = $d;
                            }
                        }else if ($item->name == 'update-creative') {
                            foreach ($delivers as $d) {
                                $d->oldValue = $item->old_value;
                                $new_links = json_decode($item->value);
                                $str = array();
                                foreach ($new_links as $link){
                                    $creative_type = CampaignCreativeLink::getCreativeLinkValue($link->creative_type);
                                    if(!empty($link->creative_type) && !empty($link->creative_link)){
                                        array_push($str,$creative_type.':'.$link->creative_link);
                                    }
                                }
                                $d->newValue = implode(";",$str);
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


}