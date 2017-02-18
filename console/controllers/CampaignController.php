<?php
namespace console\controllers;

use common\models\Campaign;
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
                $item->save();
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

    }

    public function actionSendUpdate()
    {
        // 发送 payout

        // 发送 cap
        // 发送 paused
        $pause = array();
        $cap = array();
        $payout = array();
        $models = CampaignStsUpdate::getStsSendMail();
        if (isset($models)) {
            foreach ($models as $item) {
                if ($item->type === 1) { // campaign 群发
                    $camp = Campaign::findById($item->campaign_id);
                    if (isset($camp)) {
                        $delivers = Deliver::findRunningByCampaignId($camp->id);
                        if ($item->name == 'pause') {
                            foreach ($delivers as $d) {
                                $d->newValue = $item->value;
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
                                $payout[$camp->id][] = $d;
                            }
                        }
                    }

                } else if ($item->type == 2) {  //单独发
                    $sts = Deliver::findIdentity($item->campaign_id, $item->channel_id);
                    if (isset($sts)) {
                        if ($item->name == 'pause') {
                            $sts->newValue = $item->value;
                            $pause[$item->campaign_id][] = $sts;
                        } else if ($item->name == 'cap') {
                            $sts->newValue = $item->value;
                            $cap[$item->campaign_id][] = $sts;
                        } else if ($item->name == 'payout') {
                            $sts->newValue = $item->value;
                            $payout[$item->campaign_id][] = $sts;
                        }
                    }
                }
            }
        }

        if (!empty($payout)) {

        }

        if (!empty($cap)) {
            foreach ($cap as $item) {
                MailUtil::capUpdate($item);
            }
        }

        if (!empty($pause)) {

        }
    }

    private function echoMessage($str)
    {
        echo " \t $str \n";
    }


}