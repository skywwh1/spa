<?php
/**
 * Created by ctt.
 * User: ctt
 * Date: 2017/6/16
 * Time: 9:20
 */
namespace console\controllers;

use common\models\Campaign;
use common\models\CampaignCreativeLink;
use common\models\CampaignStsUpdate;
use common\models\CampaignSubChannelLog;
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
        $sub_channel_list = CampaignSubChannelLog::getNeedPause();
        if (isset($sub_channel_list)) {
            foreach ($sub_channel_list as $item) {
                $item->is_effected = 1;
                $this->echoMessage('sub publisher paused ' . $item->campaign_id . '-' . $item->channel_id);
                $item->save();
                var_dump($item->getErrors());
            }
        }
    }

    private function echoMessage($str)
    {
        echo " \t $str \n";
    }


}