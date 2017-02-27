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
use common\models\Feed;
use common\models\LogClick;
use common\models\LogFeed;
use common\models\LogPost;
use common\models\Stream;
use common\utility\ApiUtil;
use linslin\yii2\curl\Curl;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

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

                }
            }
        }

        //2. 更新feed
        $feeds = Feed::findNeedCounts();
        $installs = array();
        if (isset($feeds)) {
            foreach ($feeds as $item) {
                $logClick = LogClick::findByClickUuid($item->click_id);
                if (isset($logClick)) {
                    $logFeed = new LogFeed();
                    $logFeed->auth_token = $item->auth_token;
                    $logFeed->click_uuid = $item->click_id;
                    $logFeed->click_id = $logClick->click_id;
                    $logFeed->channel_id = $logClick->channel_id;
                    $logFeed->campaign_id = $logClick->campaign_id;
                    $logFeed->ch_subid = $logClick->ch_subid;
                    $logFeed->all_parameters = $item->all_parameters;
                    $logFeed->ip = $item->ip;
                    $logFeed->feed_time = $item->create_time;
                    if ($logFeed->save() == false) {
                        var_dump($logFeed->getErrors());
                    } else {
                        $installs[] = $logFeed;
                    }
                } else {
                    echo 'cannot found the click log';
                }


            }
        }

        //3. 更新post 扣量
        if (isset($installs)) {
            foreach ($installs as $item) {
                if ($this->isNeedPost($item)) {
                    $post = new LogPost();
//        $post->channel_id  = $item->
//        $post->campaign_id =
//        $post->pay_out     =
//        $post->discount    =
//        $post->daily_cap   =
//        $post->post_link   =
//        $post->post_time   =
//        $post->post_status =
//        $post->create_time =
                }

            }

        }


    }

    /**
     * @param LogFeed $feed
     * @return bool
     */
    private function isNeedPost($feed)
    {
        return true;
    }
}