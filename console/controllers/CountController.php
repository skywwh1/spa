<?php
/**
 * Created by PhpStorm.
 * User: Iven.Wu
 * Date: 2017-02-10
 * Time: 10:59
 */

namespace console\controllers;


use common\models\Campaign;
use common\models\Deliver;
use common\models\Feed;
use common\models\LogClick;
use common\models\LogFeed;
use common\models\LogPost;
use common\models\Stream;
use linslin\yii2\curl\Curl;
use yii\console\Controller;

/**
 * Class TestController
 * @package console\controllers
 */
class CountController extends Controller
{

    public function actionUpdateClicks()
    {
        //1. 更新点击
        $clicks = array(); // 用来
        $posts = array();
        $newIpClicks = array(); //weiyi ip
        $streams = Stream::getCountClicks();
        $this->echoMessage('count click ' . count($streams));
        if (isset($streams)) {
            foreach ($streams as $item) {
                $camp = Campaign::findByUuid($item->cp_uid);
                if ($camp == null) {
                    $this->echoMessage('Count not found campaign ' . $item->cp_uid);
                    continue;
                }
                $click = new LogClick();
                $click->tx_id = $item->id;
                $click->click_uuid = $item->click_uuid;
                $click->click_id = $item->click_id;
                $click->channel_id = $item->ch_id;
                $click->campaign_id = $camp->id;
                $click->campaign_uuid = $item->cp_uid;
                $click->pl = $item->pl;
                $click->ch_subid = $item->ch_subid;
                $click->gaid = $item->gaid;
                $click->idfa = $item->idfa;
                $click->site = $item->site;
                $click->pay_out = $item->pay_out;
                $click->discount = $item->discount;
                $click->daily_cap = $item->daily_cap;
                $click->all_parameters = $item->all_parameters;
                $click->ip = $item->ip;
                $click->redirect = $item->redirect;
                $click->browser = $item->browser;
                $click->browser_type = $item->browser_type;
                $click->click_time = $item->create_time;
//                $click->
                if ($click->save() == false) {
                    var_dump($click->getErrors());
                } else {
                    if (isset($clicks[$click->campaign_id . '-' . $click->channel_id])) {
                        $clicks[$click->campaign_id . '-' . $click->channel_id] += 1;
                    } else {
                        $clicks[$click->campaign_id . '-' . $click->channel_id] = 1;
                    }
                    $newIpClicks[$click->campaign_id . '-' . $click->channel_id][] = $click->ip;
                }
                $item->is_count = 1;
                $item->save();
            }

            $this->echoMessage('Update clicks start :');
            if (!empty($clicks)) { //sts更新点击量
                foreach ($clicks as $k => $v) {
                    $de = explode('-', $k);
                    $sts = Deliver::findIdentity($de[0], $de[1]);
                    $sts->click += $v;
                    $this->echoMessage($de[0] . '-' . $de[1] . ' update click to ' . $sts->click);
                    $sts->save();
                }
            }
        }
        $this->echoMessage('Update clicks end ############');
    }

    public function actionUpdateFeeds()
    {
        //2. 更新feed
        $feeds = Feed::findNeedCounts();
        $this->echoMessage('Total Feeds ' . count($feeds));
        if (isset($feeds)) {
            foreach ($feeds as $item) {
                $logClick = LogClick::findByClickUuid($item->click_id);
                if (isset($logClick)) {
                    $camp = Campaign::findById($logClick->campaign_id);
                    if (empty($camp)) {
                        $this->echoMessage('cannot found the campaign -' . $logClick->campaign_id);
                        continue;
                    }
                    $sts = Deliver::findIdentity($logClick->campaign_id, $logClick->channel_id);
                    $logFeed = new LogFeed();
                    $logFeed->auth_token = $item->auth_token;
                    $logFeed->click_uuid = $item->click_id;
                    $logFeed->click_id = $logClick->click_id;
                    $logFeed->channel_id = $logClick->channel_id;
                    $logFeed->campaign_id = $logClick->campaign_id;
                    $logFeed->ch_subid = $logClick->ch_subid;
                    $logFeed->all_parameters = $item->all_parameters;
                    $logFeed->ip = $item->ip;
                    $logFeed->adv_price = $camp->adv_price;
                    $logFeed->feed_time = $item->create_time;
                    if ($logFeed->save() == false) {
                        var_dump($logFeed->getErrors());
                    } else {
                        //更新post 扣量
                        if ($this->isNeedPost($sts)) {
                            $post = new LogPost();
                            $post->click_uuid = $logFeed->click_uuid;
                            $post->click_id = $logFeed->click_id;
                            $post->channel_id = $logFeed->channel_id;
                            $post->campaign_id = $logFeed->campaign_id;
                            $post->pay_out = $logClick->pay_out;
                            $post->discount = $logClick->discount;
                            $post->daily_cap = $logClick->daily_cap;
                            $post->post_link = $this->genPostLink($sts->channel->post_back, $logClick->all_parameters);
                            //* 0:need to post, 1.posted
                            $post->post_status = 0;
                            if ($post->save() == false) {
                                var_dump($logFeed->getErrors());
                            }
                        }
                    }
                } else {
                    $this->echoMessage('cannot found the click log-channel_click_id-' . $item->click_id);
                }

                $item->is_count = 1;
                $item->save();
            }
        }

        // post back
        $this->postBack();
    }

    /**
     * @param Deliver $sts
     * @return bool
     */
    private function isNeedPost(&$sts)
    {
        $needPost = false;
        $standard = 100 - $sts->discount;
        $numerator = $sts->discount_numerator + 1;//分子
        $denominator = $sts->discount_denominator + 1;//扣量基数
        $percent = ($numerator / $denominator) * 100;
        if ($percent < $standard || $sts->install < 5) {
            $needPost = true;
            $sts->discount_numerator = $numerator;
            $sts->install += 1;
        }
        $sts->match_install += 1;
        $sts->discount_denominator = $denominator;
        if ($sts->discount_denominator >= 10) {
            $sts->discount_denominator = 0;
            $sts->discount_numerator = 0;
        }
        $sts->save();
        return $needPost;
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

    private function echoMessage($str)
    {
        echo " \t $str \n";
    }

    public function postBack()
    {
        $needPost = LogPost::findPost();
        if (!empty($needPost)) {
            $this->echoHead("Post action start at " . time());
            foreach ($needPost as $k) {
                $this->echoMessage("Click  $k->click_uuid going to post ");
                $this->echoMessage("Post to " . $k->post_link);
                $curl = new Curl();
                $response = $curl->get($k->post_link);
                var_dump($response);
                $k->post_status = 1; // 已经post
                $k->post_time = time();
                if (!$k->save()) {
                    var_dump($k->getErrors());
                }
                $this->echoMessage("Wait 1 second");
                sleep(1);
            }
            $this->echoHead("Post action end at " . time());
        } else {
            $this->echoMessage("No campaign need to post back ");
            return;
        }
    }

    private function echoHead($str)
    {
        echo "#######  $str \n\n";
    }
}