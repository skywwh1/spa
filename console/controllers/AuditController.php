<?php
namespace console\controllers;

use common\models\Campaign;
use common\models\Channel;
use common\models\Deliver;
use common\models\Feed;
use common\models\Stream;
use common\models\User;
use frontend\models\ChannelReports;
use linslin\yii2\curl\Curl;
use yii\console\Controller;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Created by PhpStorm.
 * User: wh wu
 * Date: 1/15/2017
 * Time: 3:39 PM
 */
class AuditController extends Controller
{

    public function actionIndex()
    {
        echo "sdfadsf \n";
    }

    // 10分钟一次。
    public function actionCount_feed()
    {
        date_default_timezone_set("Asia/Shanghai");
        $this->echoMessage("Time : " . date("Y-m-d H:i:s", time()));
        $needCounts = Feed::findNeedCounts();
        //更新点击量
        $this->count_clicks();
        if (!empty($needCounts)) {
            $this->echoMessage("Get feeds count " . count($needCounts));

            $matchClicks = $this->getMatch_clicks($needCounts);
            //更新campaign的真实安装量。
            $this->updateMatchInstall($matchClicks);
            // 更新feed
            $this->updateFeedStatus($needCounts);
            //更新扣量
            $this->updatePost_status($matchClicks);
        } else {
            $this->echoMessage("No feed need to update");
        }
        //post
        $this->post_back();
    }

// 每20分钟post
    protected function post_back()
    {
        $needPosts = Stream::getNeedPosts();
        if (empty($needPosts)) {
            $this->echoMessage("No campaign need to post back ");
            return;
        }
        $this->echoHead("Post action start at " . time());
        foreach ($needPosts as $k) {
            $this->echoMessage("Click  $k->click_uuid going to post ");
            $this->echoMessage("Post to " . $k->post_link);
            $curl = new Curl();
            $response = $curl->get($k->post_link);
            var_dump($response);
            $k->post_status = 3; // 已经post
            $k->post_time = time();
            if (!$k->save()) {
                var_dump($k->getErrors());
            }
            $this->echoMessage("Wait 1 second");
            sleep(1);
        }
        $this->echoHead("Post action end at " . time());
    }

    /** 更新总的安装量
     * @param array|\common\models\Stream[] $matchClicks
     */
    protected function updateMatchInstall($matchClicks)
    {
        $this->echoHead("update match install start");
        $data = array();
        $feeds = array();
        foreach ($matchClicks as $k) {
            $campaign_uuid = $k->cp_uid;
            $campaign_id = Campaign::findByUuid($campaign_uuid)->id;
            $channel_id = $k->ch_id;
            if (isset($data[$campaign_id . ',' . $channel_id])) {
                $data[$campaign_id . ',' . $channel_id] += 1;
            } else {
                $data[$campaign_id . ',' . $channel_id] = 1;
            }
            $feeds[] = $k->click_uuid;
        }
        if (!empty($data)) {
            foreach ($data as $k => $v) {
                $camp_chanl = explode(',', $k);
                $deliver = Deliver::findIdentity($camp_chanl[0], $camp_chanl[1]);
                $deliver->match_install += $v; //累加
                $deliver->discount_denominator += $v; //扣量基数
//                if ($deliver->discount_denominator >= 30 && $v < 100) { //达到30条重置扣量基数,5分钟装100个不正常的。
//                    $deliver->discount_denominator = 1;
//                    $deliver->discount_numerator = 1;
//                }
                $this->statistics($deliver);
                if (!$deliver->save()) {
                    var_dump($deliver->getErrors());
                }
                $this->echoMessage("deliver $camp_chanl[0]-$camp_chanl[1] match install update to $v");
            }
        }

        $this->echoHead("end update match install");
    }

    /**
     * @param \common\models\feed[] $feeds
     */
    protected function updateFeedStatus($feeds)
    {
        $this->echoHead("start update feed status to counted");
        foreach ($feeds as $feed) {
            $feed->is_count = 1;
            if (!$feed->save()) {
                var_dump($feed->getErrors());
            }
            $this->echoMessage("update feed {$feed->id} to counted");
        }
        $this->echoHead("end update feed status");
    }

    /**
     * 扣量算法
     * @param array|\common\models\Stream[] $matchClicks
     */
    protected function updatePost_status($matchClicks)
    {
        $this->echoHead("update post status start");
        foreach ($matchClicks as $k) {

            $k->post_status = 2; //默认不post back；
            $campaign_uuid = $k->cp_uid;
            $channel_id = $k->ch_id;
            $this->echoMessage("");
            $deliver = Deliver::findIdentityByCpUuidAndChid($campaign_uuid, $channel_id);
            if ($deliver !== null) {
                $this->echoMessage("find deliver $campaign_uuid-$channel_id");
            } else {
                $this->echoMessage("can not find deliver $campaign_uuid-$channel_id");
                continue;
            }
            $actual_install_percent = (($deliver->discount_numerator + 1) / $deliver->discount_denominator) * 100; //扣量分子除以分母。
//            $actual_install_percent = (($deliver->install + 1) / $deliver->match_install) * 100;
            $discount = 100 - $deliver->discount;
            $this->echoMessage("this deliver install is $deliver->install");
            $this->echoMessage("this deliver match install is $deliver->match_install");
            if (($deliver->install < 5) || $actual_install_percent <= $discount) { //还没达到扣标准。
                $this->echoMessage("this click will be post back");
                $deliver->install += 1;
                $deliver->discount_numerator += 1; //扣量计算分子.
                $deliver->actual_discount = ($deliver->install / $deliver->match_install) * 100; // 实际扣量。
                $k->post_status = 1; // ready to send
                $post_back = $deliver->channel->post_back;
                $k->post_link = "";
                if (!empty($post_back)) {
                    $k->post_link = $this->genPost_link($post_back, $k->all_parameters);
                }
                $this->echoMessage("post link is $k->post_link");
            } else {
                $deliver->def += 1;
                $this->echoMessage("this click will not post back");
            }
            $this->statistics($deliver);
            if ($k->save() === false) {
                $this->echoMessage("click update error");
                var_dump($k->getErrors());
            }
            if ($deliver->save() === false) {
                $this->echoMessage("deliver update error");
                var_dump($deliver->getErrors());
            }
        }
        $this->echoHead("end update post status");
    }

    /** 有效点击
     * @param array|\common\models\Feed[] $needCounts
     * @return array|\common\models\Stream[]
     */
    protected function getMatch_clicks($needCounts)
    {
        $matchClicks = array();
        foreach ($needCounts as $k) {
            $stream = Stream::findOne(['click_uuid' => $k->click_id]);
            if ($stream == null)
                continue;
            $matchClicks[] = $stream;
        }
        $this->echoMessage("Get match clicks " . count($matchClicks));
        return $matchClicks;
    }

    protected function count_clicks()
    {
        $streams = Stream::getCountClicks();
        if (empty($streams)) {
            $this->echoMessage("No clicks update");
            return;
        }
        $camps = array();
        $this->echoHead("start to count clicks");
        if (!empty($streams)) {
            foreach ($streams as $stream) {
                if (isset($camps[$stream->cp_uid . ',' . $stream->ch_id])) {
                    $camps[$stream->cp_uid . ',' . $stream->ch_id] += 1;
                } else {
                    $camps[$stream->cp_uid . ',' . $stream->ch_id] = 1;
                }
                $stream->is_count = 1;
                if ($stream->save()) {
                    $this->echoMessage("update stream {$stream->cp_uid}-{ $stream->ch_id} is counted");
                } else {
                    var_dump($stream->getErrors());
                }
            }
        }

        if (!empty($camps)) {
            foreach ($camps as $k => $v) {
                $ids = explode(',', $k);
                $deliver = Deliver::findIdentityByCpUuidAndChid($ids[0], $ids[1]);
                $deliver->click += $v;
                $deliver->unique_click = Stream::getDistinctIpClick($ids[0], $ids[1]);
                $this->statistics($deliver);
                if ($deliver->save()) {
                    $this->echoMessage("deliver $deliver->campaign_id - $deliver->channel_id");
                    $this->echoMessage("update click to $deliver->click ");
                    $this->echoMessage("update unique click to $deliver->unique_click ");
                } else {
                    var_dump($deliver->getErrors());
                }
            }
        }
        $this->echoHead("end to count clicks");
    }

    // 每天清理一遍click——log
    public function actionClear_click_log()
    {
        return parent::actions(); // TODO: Change the autogenerated stub
    }

    protected function genPost_link($postback, $allParams)
    {
        $this->echoMessage("channel post back is " . $postback);
        $this->echoMessage("click params are " . $allParams);
//        $homeurl = substr($postback, 0, strpos($postback, '?'));
//        $paramstring = substr($postback, strpos($postback, '?') + 1, strlen($postback) - 1);
//        $params = explode("&", $paramstring);
//        $returnParams = "";
//        $paramsTemp = array();
//        if (!empty($params)) {
//            foreach ($params as $k) {
//                $temp = explode('=', $k);
//                $paramsTemp[$temp[0]] = isset($temp[1]) ? $temp[1] : "";
//            }
//        }
//        if (!empty($paramsTemp)) {
//            foreach ($paramsTemp as $k => $v) {
//                if (strpos($allParams, $k) !== false) {
//                    $startCut = strpos($allParams, $k);
//                    $cutLen = (strlen($allParams) - $startCut);
//                    if (strpos($allParams, '&', $startCut)) {
//                        $cutLen = strpos($allParams, '&', $startCut) - $startCut;
//                    }
//                    $returnParams .= substr($allParams, $startCut, $cutLen) . "&";
//                }
//            }
//        }
//        if (!empty($returnParams)) {
//            $returnParams = chop($returnParams, '&');
//            $homeurl .= "?" . $returnParams;
//        } else {
//            $this->echoMessage("can not found post back params");
//        }

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
     *计算转化率
     * @param \common\models\Deliver $deliver
     */
    private function statistics(&$deliver)
    {
        $this->echoMessage("calculate benefit ");
        if ($deliver->click) {
            $deliver->cvr = $deliver->install / $deliver->click;
            $deliver->match_cvr = $deliver->match_install / $deliver->click;
        }
        $deliver->cost = $deliver->install * $deliver->campaign->adv_price;
        $deliver->revenue = $deliver->match_install * $deliver->campaign->adv_price;
        if ($deliver->match_install) {
            $deliver->actual_discount = $deliver->install / $deliver->match_install;
        }
        $deliver->profit = $deliver->revenue - $deliver->cost;
        if ($deliver->revenue) {
            $deliver->margin = $deliver->profit / $deliver->revenue;
        }
    }

    private function echoHead($str)
    {
        echo "#######  $str \n\n";
    }

    private function echoMessage($str)
    {
        echo " \t $str \n";
    }

    public function actionTest()
    {
//        var_dump(timezone_identifiers_list());
        $user = User::findOne(['id' => '3']);
        $user->setPassword('joanna');
        $user->save();

    }
}