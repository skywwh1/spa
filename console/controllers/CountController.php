<?php
/**
 * Created by PhpStorm.
 * User: Iven.Wu
 * Date: 2017-02-10
 * Time: 10:59
 */

namespace console\controllers;


use backend\models\FinanceAddCost;
use backend\models\FinanceAddRevenue;
use backend\models\FinanceAdvertiserBillTerm;
use backend\models\FinanceAdvertiserCampaignBillTerm;
use backend\models\FinanceAdvertiserPrepayment;
use backend\models\FinanceChannelBillTerm;
use backend\models\FinanceChannelCampaignBillTerm;
use backend\models\FinanceChannelPrepayment;
use backend\models\FinanceCompensation;
use backend\models\FinanceDeduction;
use backend\models\FinancePending;
use backend\models\LogClick3;
use common\models\Advertiser;
use common\models\Campaign;
use common\models\Channel;
use common\models\Config;
use common\models\Deliver;
use common\models\Feed;
use common\models\LogClick;
use common\models\LogClick2;
use common\models\LogFeed;
use common\models\LogPost;
use common\models\RedirectLog;
use common\models\Stream;
use console\models\StatsUtil;
use DateTime;
use DateTimeZone;
use linslin\yii2\curl\Curl;
use yii\console\Controller;

/**
 * Class TestController
 * @package console\controllers
 */
class CountController extends Controller
{

    public function actionUpdateClickAndFeed()
    {
        $this->actionUpdateClicks();
        $this->actionUpdateFeeds();
    }

    public function actionInsertClicks()
    {
        $now = time();
        echo date('Y-m-d\TH:i:s\Z', $now) . "\n";
        $logs = LogClick3::find()->orderBy('create_time desc')->limit(20000)->all();
        foreach ($logs as $model) {
            $click = new LogClick();
            $click->click_uuid = $model->click_uuid;
            $click->click_id = $model->click_id;
            $click->channel_id = $model->channel_id;
            $click->campaign_id = $model->campaign_id;
            $click->campaign_uuid = $model->campaign_uuid;
            $click->pl = $model->pl;
            $click->ch_subid = $model->ch_subid;
            $click->gaid = $model->gaid;
            $click->idfa = $model->idfa;
            $click->site = $model->site;
            $click->adv_price = $model->adv_price;
            $click->pay_out = $model->pay_out;
            $click->discount = $model->discount;
            $click->daily_cap = $model->daily_cap;
            $click->all_parameters = $model->all_parameters;
            $click->ip = $model->ip;
            $click->ip_long = $model->ip_long;
            $click->redirect = $model->redirect;
            $click->browser = $model->browser;
            $click->browser_type = $model->browser_type;
            $click->click_time = $model->create_time;
            $click->create_time = $model->create_time;
            if (!$click->save()) {
                var_dump($click->getErrors());
            }
            $model->delete();
        }
        echo date('Y-m-d\TH:i:s\Z', (time() - $now)) . "\n";
    }

    public function actionUpdateClicks()
    {
        //1. 更新点击
        $clicks = array(); // 用来
        $posts = array();
        $newIpClicks = array(); //weiyi ip
        echo date('Y-m-d\TH:i:s\Z', time()) . "\n";
        Stream::insertClicks();
        echo date('Y-m-d\TH:i:s\Z', time()) . "\n";
        $streams = Stream::getUpdateClicks();
        $this->echoMessage('count click ' . count($streams));
        if (isset($streams)) {
            foreach ($streams as $item) {
//                $camp = Campaign::findByUuid($item->cp_uid);
//                if ($camp == null) {
//                    $this->echoMessage('Count not found campaign ' . $item->cp_uid);
//                    continue;
//                }
//                $click = new LogClick();
//                $click->tx_id = $item->id;
//                $click->click_uuid = $item->click_uuid;
//                $click->click_id = $item->click_id;
//                $click->channel_id = $item->ch_id;
//                $click->campaign_id = $camp->id;
//                $click->campaign_uuid = $item->cp_uid;
//                $click->pl = $item->pl;
//                $click->ch_subid = $item->ch_subid;
//                $click->gaid = $item->gaid;
//                $click->idfa = $item->idfa;
//                $click->site = $item->site;
//                $click->adv_price = $item->adv_price;
//                $click->pay_out = $item->pay_out;
//                $click->discount = $item->discount;
//                $click->daily_cap = $item->daily_cap;
//                $click->all_parameters = $item->all_parameters;
//                $click->ip = $item->ip;
//                $click->ip_long = $item->ip_long;
//                $click->redirect = $item->redirect;
//                $click->browser = $item->browser;
//                $click->browser_type = $item->browser_type;
//                $click->click_time = $item->create_time;
////                $click->
//                if ($click->save() == false) {
//                    $this->echoMessage('save click error click table id ' . $item->id);
//                    var_dump($click->getErrors());
//                }
                $item->is_count = 1;
                if ($item->save() == false) {
                    $this->echoMessage('update click table to count error ' . $item->id);
                    var_dump($item->getErrors());
                } else {
                    echo 'update success' . time() . "\n";
                }

            }

//            $this->echoMessage('Update clicks start :');
//            if (!empty($clicks)) { //sts更新点击量
//                foreach ($clicks as $k => $v) {
//                    $de = explode('-', $k);
//                    $sts = Deliver::findIdentity($de[0], $de[1]);
//                    $sts->click += $v;
//                    $this->echoMessage($de[0] . '-' . $de[1] . ' update click to ' . $sts->click);
//                    $sts->save();
//                }
//            }
        }
        $this->echoMessage('Update clicks end ############' . date('Y-m-d\TH:i:s\Z', time()));
    }

    public function actionUpdateFeeds()
    {
        //2. 更新feed
        $feeds = Feed::findNeedCounts();
        $this->echoMessage('Total Feeds ' . count($feeds));
        if (isset($feeds)) {
            foreach ($feeds as $item) {
                $logClick = LogClick::findByClickUuid($item->click_id);
                if(empty($logClick)){
                    $logClick = LogClick2::findByClickUuid($item->click_id);
                }
                if (!empty($logClick)) {
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
                    $logFeed->ch_subid = empty($logClick->ch_subid) ? '0' : $logClick->ch_subid;
                    $logFeed->all_parameters = $item->all_parameters;
                    $logFeed->ip = $item->ip;
                    $logFeed->ip_long = $item->ip_long;
                    $logFeed->adv_price = $camp->adv_price;
                    if ($sts->is_redirect) {
                        $redirect = RedirectLog::findIsActive($logClick->campaign_id, $logClick->channel_id);
                        if (isset($redirect)) {
                            $logFeed->adv_price = $redirect->campaignIdNew->adv_price;
                        }
                    }
                    $logFeed->feed_time = $item->create_time;
                    $logFeed->is_redirect = $sts->is_redirect;
                    if ($logFeed->save() == false) {
                        $this->echoMessage('save log feed error');
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
                            $post->is_redirect = $sts->is_redirect;
                            $post->ch_subid = empty($logClick->ch_subid) ? '0' : $logClick->ch_subid;
                            $post->post_link = $this->genPostLink($sts->channel->post_back, $logClick->all_parameters);
                            //* 0:need to post, 1.posted
                            $post->post_status = 0;
                            if ($post->save() == false) {
                                $this->echoMessage('save log post error');
                                var_dump($post->getErrors());
                            }
                        }

                    }
                    $item->is_count = 1;
                    $item->save();
                } else {
                    $this->echoMessage('cannot found the click log from feed click_uuid ' . $item->click_id);
                }
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
        if ($sts->is_redirect) {
            $redirect = RedirectLog::findIsActive($sts->campaign_id, $sts->channel_id);
            $standard = 100 - $redirect->discount;
            $numerator = $redirect->discount_numerator + 1;//分子
            $denominator = $redirect->discount_denominator + 1;//扣量基数
            $percent = ($numerator / $denominator) * 100;
            if ($percent < $standard) {
                $needPost = true;
                $redirect->discount_numerator = $numerator;
            }
            $redirect->discount_denominator = $denominator;
            if ($redirect->discount_denominator >= 10) {
                $redirect->discount_denominator = 0;
                $redirect->discount_numerator = 0;
            }
            $redirect->save();

        } else {
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
        }

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

    public function actionPostBack()
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

    public function actionStatsHourly()
    {
        $stats = new StatsUtil();
        /**
         * 按顺序来；
         */
        $start = Config::findLastStatsHourly();
        $end = time();
        $start_time = strtotime(date("Y-m-d H:00", $start - 3600));//统计两个小时，防止出错
        $end_time = strtotime(date("Y-m-d H:00", $end + 3600));
        echo 'start time hourly' . $start_time . "\n";
        echo 'end time hourly' . $end_time . "\n";
        $stats->statsMatchInstallHourly($start_time, $end_time);
        $stats->statsRedirectMatchInstallHourly($start_time, $end_time);

        $stats->statsInstallHourly($start_time, $end_time);
        $stats->statsRedirectInstallHourly($start_time, $end_time);

//        $stats->statsUniqueClickHourly($start_time, $end_time);
//        $stats->statsClickHourly($start_time, $end_time);
        $stats->updateNullPrice();
        $stats->updateCaps();

        //统计子渠道：
        $stats->statsSubChannelMatchInstallHourly($start_time, $end_time);
        $stats->statsSubChannelRedirectMatchInstallHourly($start_time, $end_time);

        $stats->statsSubChannelInstallHourly($start_time, $end_time);
        $stats->statsSubChannelRedirectInstallHourly($start_time, $end_time);

//        $stats->statsSubChannelUniqueClickHourly($start_time, $end_time);
//        $stats->statsSubChannelClickHourly($start_time, $end_time);

//        $start_time = strtotime(date("Y-m-d", $start - 3600 * 24)); //统计两天的。
//        $end_time = strtotime(date("Y-m-d", $end + 3600 * 24));
//        echo 'start time daily' . $start_time . "\n";
//        echo 'end time daily' . $end_time . "\n";
//        $stats->statsDaily($start_time, $end_time);
        Config::updateStatsTimeHourly($end);

    }

    public function actionStatsClicksHourly()
    {
        $stats = new StatsUtil();

        $start = Config::findLastStatsClickHourly();
        $end = $start;
        $now = time();
        while ($end < $now) {
            $end = $end + 900;
            if ($end > $now) {
                $end = $now;
            }
            echo 'start click hourly ' . $start . "\n";
            echo 'end click hourly ' . $end . "\n";
            echo date('Y-m-d H:i:s', $end) . "\n";
            $stats->statsClicksHourly($start, $end);
            //sub channel;
            $stats->statsSubClicksHourly($start, $end);
            $start = $end;
        }
        //统计子渠道：

        Config::updateLastStatsClickHourly($now);

    }

    public function actionStatsDaily()
    {
        $stats = new StatsUtil();
        $start = Config::findLastStatsDaily();
        $end = time();
        $start_time = strtotime(date("Y-m-d H:00", $start - 3600));//统计两个小时，防止出错
        $end_time = strtotime(date("Y-m-d H:00", $end + 3600));
        echo 'start time hourly' . $start_time . "\n";
        echo 'end time hourly' . $end_time . "\n";
        $stats->statsMatchInstallHourly($start_time, $end_time);
        $stats->statsRedirectMatchInstallHourly($start_time, $end_time);

        $stats->statsInstallHourly($start_time, $end_time);
        $stats->statsRedirectInstallHourly($start_time, $end_time);

        $stats->statsUniqueClickHourly($start_time, $end_time);
        $stats->statsClickHourly($start_time, $end_time);
        $stats->updateNullPrice();
        $stats->updateCaps();

//        $start_time = strtotime(date("Y-m-d", $start - 3600 * 24)); //统计两天的。
//        $end_time = strtotime(date("Y-m-d", $end + 3600 * 24));
//        echo 'start time daily' . $start_time . "\n";
//        echo 'end time daily' . $end_time . "\n";
//        $stats->statsDaily($start_time, $end_time);
        Config::updateStatsTimeDaily($end);

    }

    public function actionStatsAdvertiserMonthly()
    {
        //统计上个月账单：
        $first_day_last_month = date('Y.m.d', strtotime('first day of last month'));
        $last_day_last_month = date('Y.m.d', strtotime('last day of last month'));
        $period = $first_day_last_month . '-' . $last_day_last_month;
//        echo $period;die();
        $last_bills = FinanceAdvertiserBillTerm::findAll(['period' => $period]);

//        $last_bills = FinanceAdvertiserBillTerm::findAll(['status' => 0]);
        if (!empty($last_bills)) {
            foreach ($last_bills as $item) {
                $stats = new StatsUtil();
                $rows = $stats->statsAdvertiserMonthly($item->start_time, $item->end_time, $item->adv_id);
                if (!empty($rows)) {
                    $rows = json_decode(json_encode($rows), FALSE);
                    foreach ($rows as $obj) {
                        $bill_campaign = FinanceAdvertiserCampaignBillTerm::findOne(['bill_id' => $item->bill_id, 'campaign_id' => $obj->campaign_id]);
                        if (empty($bill_campaign)) {
                            $bill_campaign = new FinanceAdvertiserCampaignBillTerm();
                        }
                        $bill_campaign->bill_id = $item->bill_id;
                        $bill_campaign->adv_id = $item->adv_id;
                        $bill_campaign->time_zone = $item->time_zone;
                        $bill_campaign->campaign_id = $obj->campaign_id;
                        $bill_campaign->start_time = $item->start_time;
                        $bill_campaign->end_time = $item->end_time;
                        $bill_campaign->clicks = $obj->clicks;
                        $bill_campaign->unique_clicks = $obj->unique_clicks;
                        $bill_campaign->installs = $obj->installs;
                        $bill_campaign->match_installs = $obj->match_installs;
                        $bill_campaign->redirect_installs = $obj->redirect_installs;
                        $bill_campaign->redirect_match_installs = $obj->redirect_match_installs;
                        $bill_campaign->pay_out = $obj->pay_out;
                        $bill_campaign->adv_price = $obj->adv_price;
                        $bill_campaign->cost = $obj->cost;
                        $bill_campaign->redirect_cost = $obj->redirect_cost;
                        $bill_campaign->revenue = $obj->revenue;
                        $bill_campaign->redirect_revenue = $obj->redirect_revenue;
                        if (!$bill_campaign->save()) {
                            var_dump($bill_campaign->getErrors());
                        }
                    }
                }
                $campaign_bill = FinanceAdvertiserCampaignBillTerm::statsByAdv($item->start_time, $item->end_time, $item->adv_id);
                if (!empty($campaign_bill) && !empty($campaign_bill->clicks)) {
                    $item->clicks = $campaign_bill->clicks;
                    $item->unique_clicks = $campaign_bill->unique_clicks;
                    $item->installs = $campaign_bill->installs;
                    $item->match_installs = $campaign_bill->match_installs;
                    $item->redirect_installs = $campaign_bill->redirect_installs;
                    $item->redirect_match_installs = $campaign_bill->redirect_match_installs;
                    $item->pay_out = $campaign_bill->pay_out;
                    $item->adv_price = $campaign_bill->adv_price;
                    $item->cost = $campaign_bill->cost;
                    $item->redirect_cost = $campaign_bill->redirect_cost;
                    $item->revenue = $campaign_bill->revenue;
                    $item->redirect_revenue = $campaign_bill->redirect_revenue;
                    $item->receivable = $campaign_bill->revenue;
                    $item->final_revenue = $campaign_bill->revenue;
                }
                $this->countAdvBill($item);
                $item->status = 1;
                $item->save();
                var_dump($item->getErrors());
            }
        }

        //每个月2号建立一个预账单，
        //查找周期为month的广告主：
        $ads = Advertiser::findAll(['payment_term' => 30]);
        foreach ($ads as $ad) {
            $first_day_str = date('Y-m-d', strtotime('first day of this month'));
            $last_day_str = date('Y-m-d', strtotime('last day of this month'));
            $timezone = $ad->timezone;
            if (empty($timezone)) {
                $timezone = 'Etc/GMT-8';
            }
            //当前时区的凌晨转为0时区
            $start_date = new DateTime(date('Y-m-d H:00', strtotime($first_day_str)), new DateTimeZone($timezone));
            $end_date = new DateTime(date('Y-m-d H:00', strtotime($last_day_str)), new DateTimeZone($timezone));
            $start_time = $start_date->getTimestamp();
            $end_time = $end_date->getTimestamp() + 3600 * 24;
            $bill_id = $ad->id . '_' . $start_date->format('Ym');
            $pre_bill = FinanceAdvertiserBillTerm::findOne(['bill_id' => $bill_id]);
            if (empty($pre_bill)) {
                $pre_bill = new FinanceAdvertiserBillTerm();
                $pre_bill->start_time = $start_time;
                $pre_bill->end_time = $end_time;
                $pre_bill->adv_id = $ad->id;
                $pre_bill->invoice_id = 'spa-' . $ad->id . '-' . substr($first_day_str, 0, 7);
                $pre_bill->time_zone = $timezone;
                $pre_bill->period = $start_date->format('Y.m.d') . '-' . $end_date->format('Y.m.d');
                $pre_bill->bill_id = $ad->id . '_' . $start_date->format('Ym');
                $pre_bill->save();
            }

        }

    }


    public function actionStatsChannelMonthly()
    {
        //统计上个月账单：
        //统计上个月账单：
        $first_day_last_month = date('Y.m.d', strtotime('first day of last month'));
        $last_day_last_month = date('Y.m.d', strtotime('last day of last month'));
        $period = $first_day_last_month . '-' . $last_day_last_month;
//        echo $period;die();
        $last_bills = FinanceChannelBillTerm::findAll(['period' => $period]);
//        $last_bills = FinanceChannelBillTerm::findAll(['status' => 0]);
        if (!empty($last_bills)) {
            foreach ($last_bills as $item) {
                $stats = new StatsUtil();
                $rows = $stats->statsChannelMonthly($item->start_time, $item->end_time, $item->channel_id);
                if (!empty($rows)) {
                    $rows = json_decode(json_encode($rows), FALSE);
                    foreach ($rows as $obj) {
                        $bill_campaign = FinanceChannelCampaignBillTerm::findOne(['bill_id' => $item->bill_id, 'campaign_id' => $obj->campaign_id]);
                        if (empty($bill_campaign)) {
                            $bill_campaign = new FinanceChannelCampaignBillTerm();
                        }
                        $bill_campaign->bill_id = $item->bill_id;
                        $bill_campaign->channel_id = $item->channel_id;
                        $bill_campaign->time_zone = $item->time_zone;
                        $bill_campaign->campaign_id = $obj->campaign_id;
                        $bill_campaign->start_time = $item->start_time;
                        $bill_campaign->end_time = $item->end_time;
                        $bill_campaign->clicks = $obj->clicks;
                        $bill_campaign->unique_clicks = $obj->unique_clicks;
                        $bill_campaign->installs = $obj->installs;
                        $bill_campaign->match_installs = $obj->match_installs;
                        $bill_campaign->redirect_installs = $obj->redirect_installs;
                        $bill_campaign->redirect_match_installs = $obj->redirect_match_installs;
                        $bill_campaign->pay_out = $obj->pay_out;
                        $bill_campaign->adv_price = $obj->adv_price;
                        $bill_campaign->cost = $obj->cost;
                        $bill_campaign->redirect_cost = $obj->redirect_cost;
                        $bill_campaign->revenue = $obj->revenue;
                        $bill_campaign->redirect_revenue = $obj->redirect_revenue;
                        if (!$bill_campaign->save()) {
                            var_dump($bill_campaign->getErrors());
                        }
                    }
                }
                $campaign_bill = FinanceChannelCampaignBillTerm::statsByAdv($item->start_time, $item->end_time, $item->channel_id);
                if (!empty($campaign_bill) && !empty($campaign_bill->clicks)) {
                    $item->clicks = $campaign_bill->clicks;
                    $item->unique_clicks = $campaign_bill->unique_clicks;
                    $item->installs = $campaign_bill->installs;
                    $item->match_installs = $campaign_bill->match_installs;
                    $item->redirect_installs = $campaign_bill->redirect_installs;
                    $item->redirect_match_installs = $campaign_bill->redirect_match_installs;
                    $item->pay_out = $campaign_bill->pay_out;
                    $item->adv_price = $campaign_bill->adv_price;
                    $item->cost = $campaign_bill->cost;
                    $item->redirect_cost = $campaign_bill->redirect_cost;
                    $item->revenue = $campaign_bill->revenue;
                    $item->redirect_revenue = $campaign_bill->redirect_revenue;
                }
                $this->countChannelBill($item);
                $item->status = 1;
                $item->save();
                var_dump($item->getErrors());
            }
        }

        //每个月2号建立一个预账单，
        //查找周期为month的广告主：
        $channels = Channel::findAll(['payment_term' => 30]);
        foreach ($channels as $channel) {
            $first_day_str = date('Y-m-d', strtotime('first day of this month'));
            $last_day_str = date('Y-m-d', strtotime('last day of this month'));
            $timezone = $channel->timezone;
            if (empty($timezone)) {
                $timezone = 'Etc/GMT-8';
            }
            //当前时区的凌晨转为0时区
            $start_date = new DateTime(date('Y-m-d H:00', strtotime($first_day_str)), new DateTimeZone($timezone));
            $end_date = new DateTime(date('Y-m-d H:00', strtotime($last_day_str)), new DateTimeZone($timezone));
            $start_time = $start_date->getTimestamp();
            $end_time = $end_date->getTimestamp() + 3600 * 24;
            $bill_id = $channel->id . '_' . $start_date->format('Ym');
            $pre_bill = FinanceChannelBillTerm::findOne(['bill_id' => $bill_id]);
            if (empty($pre_bill)) {
                $pre_bill = new FinanceChannelBillTerm();
                $pre_bill->start_time = $start_time;
                $pre_bill->end_time = $end_time;
                $pre_bill->channel_id = $channel->id;
                $pre_bill->invoice_id = 'spa-' . $channel->id . '-' . substr($first_day_str, 0, 7);
                $pre_bill->time_zone = $timezone;
                $pre_bill->period = $start_date->format('Y.m.d') . '-' . $end_date->format('Y.m.d');
                $pre_bill->bill_id = $channel->id . '_' . $start_date->format('Ym');
                $pre_bill->save();
            }
        }
    }

    public function genChannelBillByMonth()
    {
        $channels = Channel::findAll(['payment_term' => 30]);
        foreach ($channels as $channel) {
            $first_month = strtotime('first day of January ' . date('Y'));
            $current = time();
            while ($first_month < $current) {
                $current_month = date('F', $first_month);
                echo $current_month, PHP_EOL;
                $first_day_str = date('Y-m-d', strtotime('first day of ' . $current_month));
                $last_day_str = date('Y-m-d', strtotime('last day of ' . $current_month));
                $timezone = $channel->timezone;
                if (empty($timezone)) {
                    $timezone = 'Etc/GMT-8';
                }
                //当前时区的凌晨转为0时区
                $start_date = new DateTime(date('Y-m-d H:00', strtotime($first_day_str)), new DateTimeZone($timezone));
                $end_date = new DateTime(date('Y-m-d H:00', strtotime($last_day_str)), new DateTimeZone($timezone));
                $start_time = $start_date->getTimestamp();
                $end_time = $end_date->getTimestamp() + 3600 * 24;
                $bill_id = $channel->id . '_' . $start_date->format('Ym');
                $pre_bill = FinanceChannelBillTerm::findOne(['bill_id' => $bill_id]);
                if (empty($pre_bill)) {
                    $pre_bill = new FinanceChannelBillTerm();
                    $pre_bill->start_time = $start_time;
                    $pre_bill->end_time = $end_time;
                    $pre_bill->channel_id = $channel->id;
                    $pre_bill->invoice_id = 'spa-' . $channel->id . '-' . substr($first_day_str, 0, 7);
                    $pre_bill->time_zone = $timezone;
                    $pre_bill->period = $start_date->format('Y.m.d') . '-' . $end_date->format('Y.m.d');
                    $pre_bill->bill_id = $channel->id . '_' . $start_date->format('Ym');
                    $pre_bill->save();
                }
                $first_month = strtotime("+1 month", $first_month);
            }
        }
    }

    public function genAdvBillByMonth()
    {
        $ads = Advertiser::findAll(['payment_term' => 30]);
        foreach ($ads as $ad) {
            $first_month = strtotime('first day of January ' . date('Y'));
            $current = time();
            while ($first_month < $current) {
                $current_month = date('F', $first_month);
                echo $current_month, PHP_EOL;
                $first_day_str = date('Y-m-d', strtotime('first day of ' . $current_month));
                $last_day_str = date('Y-m-d', strtotime('last day of ' . $current_month));
                $timezone = $ad->timezone;
                if (empty($timezone)) {
                    $timezone = 'Etc/GMT-8';
                }
                //当前时区的凌晨转为0时区
                $start_date = new DateTime(date('Y-m-d H:00', strtotime($first_day_str)), new DateTimeZone($timezone));
                $end_date = new DateTime(date('Y-m-d H:00', strtotime($last_day_str)), new DateTimeZone($timezone));
                $start_time = $start_date->getTimestamp();
                $end_time = $end_date->getTimestamp() + 3600 * 24;
                $bill_id = $ad->id . '_' . $start_date->format('Ym');
                $pre_bill = FinanceAdvertiserBillTerm::findOne(['bill_id' => $bill_id]);
                if (empty($pre_bill)) {
                    $pre_bill = new FinanceAdvertiserBillTerm();
                    $pre_bill->start_time = $start_time;
                    $pre_bill->end_time = $end_time;
                    $pre_bill->adv_id = $ad->id;
                    $pre_bill->invoice_id = 'spa-' . $ad->id . '-' . substr($first_day_str, 0, 7);
                    $pre_bill->time_zone = $timezone;
                    $pre_bill->period = $start_date->format('Y.m.d') . '-' . $end_date->format('Y.m.d');
                    $pre_bill->bill_id = $ad->id . '_' . $start_date->format('Ym');
                    $pre_bill->save();
                }
                $first_month = strtotime("+1 month", $first_month);
            }
        }
    }

    /**
     * @param FinanceAdvertiserBillTerm $model
     */
    private function countAdvBill(&$model)
    {
//      final_revenue = systemRevenue+add_historic-pendingRevenue-deduction_value+addRevenue
//      receivable = systemRevenue+add_historic-pendingRevenue-deduction_value+addRevenue-adjustRevenue
//      history revenue
        //pending
        $pends = FinancePending::findAll(['adv_bill_id' => $model->bill_id,'status' => 0]);
        if (!empty($pends)) {
            foreach ($pends as $item) {
                $model->pending += $item->revenue;
                $model->receivable -= $item->revenue;
                $model->final_revenue -= $item->revenue;
            }
        }
        //deduction
        $deductions = FinanceDeduction::findAll(['adv_bill_id' => $model->bill_id]);
//        $deductions = FinanceDeduction::getConfirmOrCompensatedDeduction($model->bill_id);
        if (!empty($deductions)) {
            foreach ($deductions as $item) {
                $model->deduction += $item->deduction_revenue;
                $model->receivable -= $item->deduction_revenue;
                $model->final_revenue -= $item->deduction_revenue;
            }
        }
        //add revenue
        $addRevenue = FinanceAddRevenue::findAll(['advertiser_bill_id' => $model->bill_id]);
        if (!empty($addRevenue)) {
            foreach ($addRevenue as $item) {
                $model->add_revenue += $item->revenue;
                $model->receivable += $item->revenue;
                $model->final_revenue += $item->revenue;
            }
        }
        //prepayment
        $prepayments = FinanceAdvertiserPrepayment::findAll(['advertiser_bill_id' => $model->bill_id]);
        if (!empty($prepayments)) {
            foreach ($prepayments as $item) {
                $model->prepayment += $item->prepayment;
            }
        }
    }

    /**
     * @param FinanceChannelBillTerm $model
     */
    private function countChannelBill(&$model)
    {
//      payable = systemCost+add_historicCost-pendingCost-deduction_value+addCost+compensation-adjustCost
//      final_cost = systemCost+add_historicCost-pendingCost-deduction_value+addCost
//        history cost
        //pending
        $pends = FinancePending::findAll(['channel_bill_id' => $model->bill_id,'status' => 0]);
        if (!empty($pends)) {
            foreach ($pends as $item) {
                $model->pending += $item->cost;
                $model->payable -= $item->cost;
                $model->final_cost -= $item->cost;
            }
        }
        //deduction
//        $deductions = FinanceDeduction::findAll(['channel_bill_id' => $model->bill_id,'status' => 1]);
        $deductions = FinanceDeduction::getConfirmOrCompensatedDeduction($model->bill_id);
        if (!empty($deductions)) {
            foreach ($deductions as $item) {
                $model->deduction += $item->deduction_cost;
                $model->payable -= $item->deduction_cost;
                $model->final_cost -= $item->deduction_cost;
            }
        }
//        add cost
//        $addCost = FinanceAddCost::findAll(['channel_bill_id' => $model->bill_id]);
//        if (!empty($addCost)) {
//            foreach ($addCost as $item) {
//                $model->add_cost += $item->cost;
////                $model->payable -= $item->cost;
////                $model->payable += $item->cost;
////                $model->final_cost += $item->cost;
//            }
//        }
        //compensation
//        $deduction_ids = FinanceDeduction::getDeductionIds( $model->bill_id);
//        $compensation = FinanceCompensation::getApprovedCompensation($deduction_ids);
//        if (!empty($compensation)) {
//            foreach ($compensation as $item) {
//                $model->compensation += $item->compensation;
//                $model->payable += $item->compensation;
//            }
//        }
        //prepayment
        $prepayments = FinanceChannelPrepayment::findAll(['channel_bill_id' => $model->bill_id]);
        if (!empty($prepayments)) {
            foreach ($prepayments as $item) {
                $model->apply_prepayment += $item->prepayment;
            }
        }
    }

    public function actionTest()
    {
        date_default_timezone_set('Etc/GMT-8');
//        echo strtotime('2017/05/11');
        $stats = new StatsUtil();

        $start = strtotime('2017/05/11');
        $end = $start;
        $now = time();
        while ($end < $now) {
            $end = $end + 900;
            if ($end > $now) {
                $end = $now;
            }
            echo 'start click hourly ' . $start . "\n";
            echo 'end click hourly ' . $end . "\n";
            echo date('Y-m-d H:i:s', $end) . "\n";
            $stats->statsSubClicksHourly($start, $end);
            $start = $end;
        }
    }

    public function actionCheckCvr()
    {
        $start = Config::findLastCheckCvr();
        $end = time();
        // 检查cvr
        $stats = new StatsUtil();
        $stats->checkCvr($start);
        $stats->checkCap();
        Config::updateLastCheckCvr($end);

    }

    public function actionStatsAdvertiserByMonth($date)
    {
        //统计上个月账单：
        $first_day = date("Y.m.01",strtotime($date));
        $last_day = date("Y.m.t",strtotime("$date 1 month -1 day"));
        $period = $first_day . '-' . $last_day;
        var_dump($period);
        //当前时区的凌晨转为0时区
        $last_bills = FinanceAdvertiserBillTerm::findAll(['period' => $period]);

        if (!empty($last_bills)) {
            foreach ($last_bills as $item) {
                $stats = new StatsUtil();
                $rows = $stats->statsAdvertiserMonthly($item->start_time, $item->end_time, $item->adv_id);
                if (!empty($rows)) {
                    $rows = json_decode(json_encode($rows), FALSE);
                    foreach ($rows as $obj) {
                        $bill_campaign = FinanceAdvertiserCampaignBillTerm::findOne(['bill_id' => $item->bill_id, 'campaign_id' => $obj->campaign_id, 'channel_id' => $obj->channel_id]);
                        if (empty($bill_campaign)) {
                            $bill_campaign = new FinanceAdvertiserCampaignBillTerm();
                        }
                        $bill_campaign->bill_id = $item->bill_id;
                        $bill_campaign->adv_id = $item->adv_id;
                        $bill_campaign->time_zone = $item->time_zone;
                        $bill_campaign->campaign_id = $obj->campaign_id;
                        $bill_campaign->channel_id = $obj->channel_id;
                        $bill_campaign->start_time = $item->start_time;
                        $bill_campaign->end_time = $item->end_time;
                        $bill_campaign->clicks = $obj->clicks;
                        $bill_campaign->unique_clicks = $obj->unique_clicks;
                        $bill_campaign->installs = $obj->installs;
                        $bill_campaign->match_installs = $obj->match_installs;
                        $bill_campaign->redirect_installs = $obj->redirect_installs;
                        $bill_campaign->redirect_match_installs = $obj->redirect_match_installs;
                        $bill_campaign->pay_out = $obj->pay_out;
                        $bill_campaign->adv_price = $obj->adv_price;
                        $bill_campaign->cost = $obj->cost;
                        $bill_campaign->redirect_cost = $obj->redirect_cost;
                        $bill_campaign->revenue = $obj->revenue;
                        $bill_campaign->redirect_revenue = $obj->redirect_revenue;
                        if (!$bill_campaign->save()) {
                            var_dump($bill_campaign->getErrors());
                        }

                    }
                }
                var_dump(date("Y-m-d H:i:s",$item->start_time), date("Y-m-d H:i:s",$item->end_time), $item->adv_id);
                $campaign_bill = FinanceAdvertiserCampaignBillTerm::statsByAdv($item->start_time, $item->end_time, $item->adv_id);
                if (!empty($campaign_bill) && !empty($campaign_bill->clicks)) {
                    $item->clicks = $campaign_bill->clicks;
                    $item->unique_clicks = $campaign_bill->unique_clicks;
                    $item->installs = $campaign_bill->installs;
                    $item->match_installs = $campaign_bill->match_installs;
                    $item->redirect_installs = $campaign_bill->redirect_installs;
                    $item->redirect_match_installs = $campaign_bill->redirect_match_installs;
                    $item->pay_out = $campaign_bill->pay_out;
                    $item->adv_price = $campaign_bill->adv_price;
                    $item->cost = $campaign_bill->cost;
                    $item->redirect_cost = $campaign_bill->redirect_cost;
                    $item->revenue = $campaign_bill->revenue;
                    $item->redirect_revenue = $campaign_bill->redirect_revenue;
                    $item->receivable = $campaign_bill->revenue;
                    $item->final_revenue = $campaign_bill->revenue;
                }
                $this->countAdvBillApr($item);
                $item->status = 1;
                $item->save();
                var_dump($item->getErrors());
            }
        }
    }

    public function actionStatsChannelByMonth($date)
    {
        //统计上个月账单：
//        $first_day_last_month = date('Y.m.01', strtotime('-1 month'));
//        $last_day_last_month = date('Y.m.t', strtotime('-1 month'));
        $first_day = date("Y.m.01",strtotime($date));
        $last_day = date("Y.m.t",strtotime("$date 1 month -1 day"));
        $period = $first_day . '-' . $last_day;
//        $period = $first_day_last_month . '-' . $last_day_last_month;
//        echo $period;
//        die();
        $last_bills = FinanceChannelBillTerm::findAll(['period' => $period]);
//        $last_bills = FinanceChannelBillTerm::findAll(['status' => 0]);
        if (!empty($last_bills)) {
            foreach ($last_bills as $item) {
                $stats = new StatsUtil();
                $rows = $stats->statsChannelMonthly($item->start_time, $item->end_time, $item->channel_id);
                if (!empty($rows)) {
                    $rows = json_decode(json_encode($rows), FALSE);
                    foreach ($rows as $obj) {
                        $bill_campaign = FinanceChannelCampaignBillTerm::findOne(['bill_id' => $item->bill_id, 'campaign_id' => $obj->campaign_id]);
                        if (empty($bill_campaign)) {
                            $bill_campaign = new FinanceChannelCampaignBillTerm();
                        }
                        $bill_campaign->bill_id = $item->bill_id;
                        $bill_campaign->channel_id = $item->channel_id;
                        $bill_campaign->time_zone = $item->time_zone;
                        $bill_campaign->campaign_id = $obj->campaign_id;
                        $bill_campaign->start_time = $item->start_time;
                        $bill_campaign->end_time = $item->end_time;
                        $bill_campaign->clicks = $obj->clicks;
                        $bill_campaign->unique_clicks = $obj->unique_clicks;
                        $bill_campaign->installs = $obj->installs;
                        $bill_campaign->match_installs = $obj->match_installs;
                        $bill_campaign->redirect_installs = $obj->redirect_installs;
                        $bill_campaign->redirect_match_installs = $obj->redirect_match_installs;
                        $bill_campaign->pay_out = $obj->pay_out;
                        $bill_campaign->adv_price = $obj->adv_price;
                        $bill_campaign->cost = $obj->cost;
                        $bill_campaign->redirect_cost = $obj->redirect_cost;
                        $bill_campaign->revenue = $obj->revenue;
                        $bill_campaign->redirect_revenue = $obj->redirect_revenue;
                        if (!$bill_campaign->save()) {
                            var_dump($bill_campaign->getErrors());
                        }
                    }
                }
                $campaign_bill = FinanceChannelCampaignBillTerm::statsByAdv($item->start_time, $item->end_time, $item->channel_id);

                if (!empty($campaign_bill) && !empty($campaign_bill->clicks)) {
                    $item->clicks = $campaign_bill->clicks;
                    $item->unique_clicks = $campaign_bill->unique_clicks;
                    $item->installs = $campaign_bill->installs;
                    $item->match_installs = $campaign_bill->match_installs;
                    $item->redirect_installs = $campaign_bill->redirect_installs;
                    $item->redirect_match_installs = $campaign_bill->redirect_match_installs;
                    $item->pay_out = $campaign_bill->pay_out;
                    $item->adv_price = $campaign_bill->adv_price;
                    $item->cost = $campaign_bill->cost;
                    $item->redirect_cost = $campaign_bill->redirect_cost;
                    $item->revenue = $campaign_bill->revenue;
                    $item->redirect_revenue = $campaign_bill->redirect_revenue;
                }
                $this->countChannelBillApr($item);
                $item->status = 1;
                $item->save();
                var_dump($item->getErrors());
            }
        }
    }

    /**
     * @param FinanceAdvertiserBillTerm $model
     */
    private function countAdvBillApr(&$model)
    {
        $model->final_revenue = $model->revenue;
        $model->receivable = $model->revenue;
        $pends = FinancePending::findAll(['adv_bill_id' => $model->bill_id,'status' => 0]);
        $model->pending = 0;
        if (!empty($pends)) {
            foreach ($pends as $item) {
                $model->pending += $item->revenue;
                $model->receivable -= $item->revenue;
                $model->final_revenue -= $item->revenue;
            }
        }
        //deduction
        $deductions = FinanceDeduction::findAll(['adv_bill_id' => $model->bill_id]);
//        $deductions = FinanceDeduction::getConfirmOrCompensatedDeduction($model->bill_id);
        $model->deduction = 0;
        if (!empty($deductions)) {
            foreach ($deductions as $item) {
                $model->deduction += $item->deduction_revenue;
                $model->receivable -= $item->deduction_revenue;
                $model->final_revenue -= $item->deduction_revenue;
            }
        }
        //add revenue
        $addRevenue = FinanceAddRevenue::findAll(['advertiser_bill_id' => $model->bill_id]);
        $model->add_revenue = 0;
        if (!empty($addRevenue)) {
            foreach ($addRevenue as $item) {
                $model->add_revenue += $item->revenue;
                $model->receivable += $item->revenue;
                $model->final_revenue += $item->revenue;
            }
        }
        //prepayment
        $prepayments = FinanceAdvertiserPrepayment::findAll(['advertiser_bill_id' => $model->bill_id]);
        $model->prepayment = 0;
        if (!empty($prepayments)) {
            foreach ($prepayments as $item) {
                $model->prepayment += $item->prepayment;
            }
        }
    }

    /**
     * @param FinanceChannelBillTerm $model
     */
    private function countChannelBillApr(&$model)
    {
        $model->final_cost = $model->cost;
        $model->payable = $model->cost;
        //pending
        $pends = FinancePending::findAll(['channel_bill_id' => $model->bill_id,'status' => 0]);
//        var_dump($model->bill_id);
        $model->pending = 0;
        if (!empty($pends)) {
            foreach ($pends as $item) {
                $model->pending += $item->cost;
                $model->payable -= $item->cost;
                $model->final_cost -= $item->cost;
            }
        }
        //deduction
//        $deductions = FinanceDeduction::findAll(['channel_bill_id' => $model->bill_id,'status' => 1]);
        $deductions = FinanceDeduction::getConfirmOrCompensatedDeduction($model->bill_id);
        $model->deduction = 0;
        if (!empty($deductions)) {
            foreach ($deductions as $item) {
                $model->deduction += $item->deduction_value;
                $model->payable -= $item->deduction_value;
                $model->final_cost -= $item->deduction_value;
            }
        }
//        add cost
        $addCost = FinanceAddCost::findAll(['channel_bill_id' => $model->bill_id]);
        $model->add_cost = 0;
        if (!empty($addCost)) {
            foreach ($addCost as $item) {
                $model->add_cost += $item->cost;
                $model->payable += $item->cost;
//                $model->payable += $item->cost;
//                $model->final_cost += $item->cost;
            }
        }

        //prepayment
        $prepayments = FinanceChannelPrepayment::findAll(['channel_bill_id' => $model->bill_id]);
        $model->apply_prepayment = 0;
        if (!empty($prepayments)) {
            foreach ($prepayments as $item) {
                $model->apply_prepayment += $item->prepayment;
            }
        }
    }
}