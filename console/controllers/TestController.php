<?php
/**
 * Created by PhpStorm.
 * User: Iven.Wu
 * Date: 2017-02-10
 * Time: 10:59
 */

namespace console\controllers;


use common\models\Advertiser;
use common\models\AdvertiserApi;
use common\models\ApiCampaign;
use common\models\Campaign;
use common\models\Deliver;
use common\models\Feed;
use common\models\LogClick;
use common\models\LogFeed;
use common\models\LogPost;
use common\models\Stream;
use common\utility\ApiUtil;
use linslin\yii2\curl\Curl;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

/**
 * Class TestController
 * @package console\controllers
 */
class TestController extends Controller
{

    public function actionTest()
    {
//        var_dump(Stream::getCountClicks());
//        var_dump(md5('ch58a6d7f5e4fec58a6d7f5e5091'));

        http://api.superads.cn/v1/offers?token=8e5c1e70c5507cf8a556638e68de38c8&u=oneapi&page_size=10&page=1

        $c = new Curl();
        $c->get('http://api.superads.cn/v1/offers?token=8e5c1e70c5507cf8a556638e68de38c8&u=oneapi&page_size=10&page=1');
        var_dump($c->response);
    }

    public function actionCount()
    {
        //1. 更新点击
        $clicks = array(); // 用来
        $posts = array();

        $streams = Stream::getCountClicks();
        if (isset($streams)) {
            foreach ($streams as $item) {
                $camp = Campaign::findByUuid($item->cp_uid);
                if ($camp == null) {

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

                if ($click->save() == false) {
                    var_dump($click->getErrors());
                } else {
                    if (isset($clicks[$click->campaign_id . '-' . $click->channel_id])) {
                        $clicks[$click->campaign_id . '-' . $click->channel_id] += 1;
                    } else {
                        $clicks[$click->campaign_id . '-' . $click->channel_id] = 1;
                    }
                }
                $item->is_count = 1;
            }

            if (!empty($clicks)) { //sts更新点击量
                foreach ($clicks as $k => $v) {
                    $de = explode('-', $k);
                    $sts = Deliver::findIdentity($de[0], $de[1]);
                    $uniqueClicks = LogClick::findUniqueClicks($de[0], $de[1]);
                    $sts->click += $v;
                    $sts->unique_click = $uniqueClicks;
                    $sts->save();
                }
            }
        }

        //2. 更新feed
        $feeds = Feed::findNeedCounts();

        $installs = array();
        if (isset($feeds)) {
            foreach ($feeds as $item) {
                $logClick = LogClick::findByClickUuid($item->click_id);
                $camp = Campaign::findById($logClick->campaign_id);
                $sts = Deliver::findIdentity($logClick->campaign_id, $logClick->channel_id);
                if (isset($logClick) && isset($camp)) {
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
                            $post->post_status = 0;
                            if ($post->save() == false) {
                                var_dump($logFeed->getErrors());
                            }
                        }
                    }
                } else {
                    echo 'cannot found the click log or campaign';
                }

                $item->is_count = 1;
            }
        }


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
        $percent = $numerator / $denominator;
        if ($percent < $standard) {
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
}