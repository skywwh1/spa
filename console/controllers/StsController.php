<?php
namespace console\controllers;

use common\models\Channel;
use common\models\Deliver;
use common\utility\MailUtil;
use yii\console\Controller;

/**
 * Created by PhpStorm.
 * User: wh wu
 * Date: 1/15/2017
 * Time: 3:39 PM
 */
class StsController extends Controller
{

    public function actionSendCreate()
    {
        $delivers = Deliver::getAllNeedSendCreate();
        if (!empty($delivers)) {
            $data = array();
            foreach ($delivers as $deliver) {
                $data[$deliver->channel_id][] = $deliver;
            }
            foreach ($data as $k => $v) {
                $channel = Channel::findOne(['id' => $k]);
                $this->echoMessage("Time : " . date("Y-m-d H:i:s", time()));
                $this->echoMessage(MailUtil::sendStsChannelMail($channel, $v));
            }
        }
    }

    private function echoMessage($str)
    {
        echo " \t $str \n";
    }
}