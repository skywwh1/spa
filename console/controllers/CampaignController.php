<?php
namespace console\controllers;

use common\models\CampaignStsUpdate;
use common\models\Deliver;
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
        CampaignStsUpdate::getStsUpdateCap();
    }

    private function echoMessage($str)
    {
        echo " \t $str \n";
    }


}