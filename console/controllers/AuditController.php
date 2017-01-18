<?php
namespace console\controllers;

use common\models\Campaign;
use common\models\Deliver;
use common\models\Feed;
use common\models\Stream;
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
        $needCounts = Feed::findNeedCounts();
        $matchClicks = $this->getMatch_clicks($needCounts);
        //更新campaign的真实安装量。
        $this->updateMatchInstall($matchClicks);
        //更新扣量
        $this->updatePost_status($matchClicks);
        //更新点击量
        $this->count_clicks();
    }

// 每20分钟post
    public function actionPost_back()
    {
        $this->echoWord("Post action start at " . time());
        $curl = new Curl();
        $needPosts = Stream::getNeedPosts();
        foreach ($needPosts as $k) {
            $response = $curl->get($k->post_link);
            $k->post_status = 3; // 已经post
            $k->post_time = time();
            $k->save();
            echo " \n";
            echo "Post to " . $k->post_link . " \n";
            echo "waiting 5 seconds \n";
            echo "Time: " . time() . " \n";
            sleep(5);
        }
        $this->echoWord("Post action end at " . time());
    }

    /** 更新总的安装量
     * @param array|\common\models\Stream[] $matchClicks
     */
    protected function updateMatchInstall($matchClicks)
    {
        $this->echoWord("update match install start");
        if ($matchClicks == null || empty($matchClicks))
            return;
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
                $deliver->channel0 = 'aaa';
                $deliver->save();
                echo "campaign $camp_chanl[0], $camp_chanl[1] match install update to $v \n";
            }
        }
        // TODO 更新feed 的状态。
        echo "--- update feed status \n";
        if (!empty($feeds)) {
            foreach ($feeds as $k) {

                $feed = Feed::getOneByClickId($k);
                //*********************************************************************************************************
                $feed->is_count = 1;
                $feed->save();
                echo "update feed {$feed->id} to counted \n";
            }
        }
        echo "--- end update feed status \n";
        $this->echoWord("update match install end");
    }

    /**
     * @param array|\common\models\Stream[] $matchClicks
     */
    protected function updatePost_status($matchClicks)
    {
        $this->echoWord("update post status start");
        if ($matchClicks == null || empty($matchClicks))
            return;
        foreach ($matchClicks as $k) {

            $k->post_status = 2; //默认不post back；
            $campaign_uuid = $k->cp_uid;
            $channel_id = $k->ch_id;
            echo "campaign_uuid = " . $campaign_uuid . "\n";
            echo "channel_id = " . $channel_id . "\n";
            $deliver = Deliver::findIdentityByCpUuidAndChid($campaign_uuid, $channel_id);
//            var_dump($deliver);
            $actual_install_percent = (($deliver->install + 1) / $deliver->match_install) * 100;
            $discount = 100 - $deliver->discount;
            echo "install = " . $deliver->install . "\n";
            echo "match install = " . $deliver->match_install . "\n";
            if (($deliver->install < 5) || $actual_install_percent <= $discount) { //还没达到扣标准。
                $deliver->install += 1;
                $deliver->actual_discount = $actual_install_percent;
                $k->post_status = 1; // ready to send
                $post_back = $deliver->channel->post_back;
                $k->post_link = "";
                if (!empty($post_back)) {
                    $k->post_link = $this->genPost_link($post_back, $k->all_parameters);
                }
            }
            echo "discount=" . $discount . "\n ======";
            echo "post link       {$k->post_link}            \n";
            $k->save();
            $deliver->save();
        }
        $this->echoWord("update post status end");
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
        return $matchClicks;
    }

    protected function count_clicks()
    {
        $this->echoWord("start to count clicks");
        $streams = Stream::getCountClicks();
        $camps = array();
        if (!empty($streams)) {
            foreach ($streams as $stream) {
                if (isset($camps[$stream->cp_uid . ',' . $stream->ch_id])) {
                    $camps[$stream->cp_uid . ',' . $stream->ch_id] += 1;
                } else {
                    $camps[$stream->cp_uid . ',' . $stream->ch_id] = 1;
                }
                echo "update stream {$stream->cp_uid}-{ $stream->ch_id} is counted";
                $stream->is_count = 1;
                $stream->save();
            }
        }

        if (!empty($camps)) {
            foreach ($camps as $k => $v) {
                $ids = explode(',', $k);
                $deliver = Deliver::findIdentityByCpUuidAndChid($ids[0], $ids[1]);
                $deliver->click += $v;
                $deliver->unique_click = Stream::getDistinctIpClick($ids[0], $ids[1]);
                $deliver->save();
            }
        }
        $this->echoWord("end to count clicks");
    }

    // 每天清理一遍click——log
    public function actionClear_click_log()
    {
        return parent::actions(); // TODO: Change the autogenerated stub
    }

    protected function genPost_link($postback, $allParams)
    {
        echo "post back $postback \n";
        echo "all param $allParams \n";
        echo "genarate url start \n";
        $homeurl = substr($postback, 0, strpos($postback, '?'));
        $paramstring = substr($postback, strpos($postback, '?') + 1, strlen($postback) - 1);
        $params = explode("&", $paramstring);
        $returnParams = "";
        $paramsTemp = array();
        if (!empty($params)) {
            foreach ($params as $k) {
                $temp = explode('=', $k);
                $paramsTemp[$temp[0]] = isset($temp[1]) ? $temp[1] : "";
            }
        }
        if (!empty($paramsTemp)) {
            foreach ($paramsTemp as $k => $v) {
                if (strpos($allParams, $k) !== false) {
                    $startCut = strpos($allParams, $k);
                    $cutLen = (strlen($allParams) - $startCut);
                    if (strpos($allParams, '&', $startCut)) {
                        $cutLen = strpos($allParams, '&', $startCut) - $startCut;
                    }
                    $returnParams .= substr($allParams, $startCut, $cutLen) . "&";
                }
            }
        }
        if (!empty($returnParams)) {
            $returnParams = chop($returnParams, '&');
            $homeurl .= "?" . $returnParams;
        }
        echo "\n genarate url : " . $homeurl . "\n";
        return $homeurl;
    }

    protected function genPostBack($postback, $track, $allParams)
    {
        echo "genarate url start \n";
        $homeurl = substr($postback, 0, strpos($postback, '?'));
        $paramstring = substr($postback, strpos($postback, '?') + 1, strlen($postback) - 1);
        $params = explode("&", $paramstring);
        $returnParams = "";
        $paramsTemp = array();
        if (!empty($params)) {
            foreach ($params as $k) {
                $temp = explode('=', $k);
                $paramsTemp[$temp[0]] = isset($temp[1]) ? $temp[1] : "";
            }
        }
        if (!empty($paramsTemp)) {
            foreach ($paramsTemp as $k => $v) {
                if (strpos($allParams, $k)) {
                    $startCut = strpos($allParams, $k);
                    $cutLen = (strlen($allParams) - $startCut);
                    if (strpos($allParams, '&', $startCut)) {
                        $cutLen = strpos($allParams, '&', $startCut) - $startCut;
                    }
                    $returnParams .= substr($allParams, $startCut, $cutLen) . "&";
                }
            }
        }
        if (!empty($returnParams)) {
            $returnParams = chop($returnParams, '&');
            $homeurl .= "?" . $returnParams;
        }
        echo "\n genarate url : " . $homeurl . "\n";
        return $homeurl;
    }

    private function echoWord($str)
    {
        echo "===============================  $str  ======================== \n";
    }
}