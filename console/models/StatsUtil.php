<?php
/**
 * Created by PhpStorm.
 * User: iven.wu
 * Date: 3/2/2017
 * Time: 9:56 PM
 */

namespace console\models;


use common\models\Advertiser;
use common\models\Campaign;
use common\models\CampaignLogDaily;
use common\models\CampaignLogHourly;
use common\models\CampaignLogSubChannelHourly;
use common\models\Config;
use common\models\Deliver;
use common\models\LogAutoCheck;
use common\models\LogFeedHourly;
use common\utility\MailUtil;
use Yii;
use yii\db\Query;

class StatsUtil
{

    public function statsClickHourly($start_time, $end_time)
    {
        $this->statsHourly(1, $start_time, $end_time);
    }

    public function statsUniqueClickHourly($start_time, $end_time)
    {
        $this->statsHourly(2, $start_time, $end_time);
    }

    public function statsMatchInstallHourly($start_time, $end_time)
    {
        $this->statsHourly(4, $start_time, $end_time);
    }

    public function statsInstallHourly($start_time, $end_time)
    {
        $this->statsHourly(3, $start_time, $end_time);
    }

    public function statsRedirectInstallHourly($start_time, $end_time)
    {
        $this->statsHourly(6, $start_time, $end_time);
    }

    public function statsRedirectMatchInstallHourly($start_time, $end_time)
    {
        $this->statsHourly(5, $start_time, $end_time);
    }

    public function statsDaily($start_time, $end_time)
    {
        date_default_timezone_set("Asia/Shanghai");
        Yii::$app->db->createCommand('set time_zone="+8:00"')->execute();
        $query = new Query();
        $query->select(['clh.campaign_id',
            'clh.channel_id',
            'FROM_UNIXTIME(clh.time,"%Y-%m-%d") timeformat',
            'UNIX_TIMESTAMP(FROM_UNIXTIME(
                clh.time,
                "%Y-%m-%d"
            )) timestamp',
            'SUM(clh.clicks) clicks',
            'SUM(clh.unique_clicks) unique_clicks',
            'SUM(clh.installs) installs',
            'SUM(clh.match_installs) match_installs',
            'AVG(clh.pay_out) pay_out',
            'AVG(clh.adv_price) adv_price'
        ]);
        $query->from('campaign_log_hourly clh');
        $query->where(['>=', 'time', $start_time]);
        $query->andWhere(['<=', 'time', $end_time]);

        $query->groupBy(['clh.campaign_id',
            'clh.channel_id',
            'timeformat', 'timestamp']);
        $query->orderBy('timestamp');

        $command = $query->createCommand();
        var_dump($command->sql);
        $rows = $command->queryAll();

        foreach ($rows as $item) {
            $channel_id = '';
            $campaign_id = '';
            $timestamp = '';
            $time = '';
            $clicks = '';
            $unique_clicks = '';
            $installs = '';
            $match_installs = '';
            $pay_out = '';
            $adv_price = '';
            foreach ($item as $k => $v) {
                if ($k == 'channel_id') {
                    $channel_id = $v;
                }
                if ($k == 'campaign_id') {
                    $campaign_id = $v;
                }
                if ($k == 'timestamp') {
                    $timestamp = $v;
                }
                if ($k == 'timeformat') {
                    $time = $v;
                }
                if ($k == 'clicks') {
                    $clicks = $v;
                }
                if ($k == 'unique_clicks') {
                    $unique_clicks = $v;
                }
                if ($k == 'installs') {
                    $installs = $v;
                }
                if ($k == 'match_installs') {
                    $match_installs = $v;
                }
                if ($k == 'pay_out') {
                    $pay_out = $v;
                }
                if ($k == 'adv_price') {
                    $adv_price = $v;
                }
            }
            $hourly = CampaignLogDaily::findIdentity($campaign_id, $channel_id, $timestamp);
            if (empty($hourly)) {
                $hourly = new CampaignLogDaily();
                $hourly->channel_id = $channel_id;
                $hourly->campaign_id = $campaign_id;
                $hourly->time = $timestamp;
                $hourly->time_format = $time;
            }
            $hourly->clicks = $clicks;
            $hourly->unique_clicks = $unique_clicks;
            $hourly->installs = $installs;
            $hourly->match_installs = $match_installs;
            $hourly->pay_out = $pay_out;
            $hourly->adv_price = $adv_price;
            if (!$hourly->save()) {
                var_dump($hourly->getErrors());
            }
        }
    }

    public function statsHourly($type, $start_time, $end_time)
    {
        date_default_timezone_set("Asia/Shanghai");
        $from = 'log_click fc';
        $clicks_select = 'count(*) clicks';
        $timestamp_select = 'fc.create_time';
        $pay_out_select = '';
        $adv_price_select = '';
        $cost_select = '';
        $revenue_select = '';
        switch ($type) {
            case 1:
                $from = 'log_click fc';
                $clicks_select = 'count(*) clicks';
                break;
            case 2:
                $from = 'log_click fc';
                $clicks_select = 'count(distinct(fc.ip_long)) clicks';
                break;
            case 3:
                $from = 'log_post fc';
                $timestamp_select = 'fc.post_time';
                $clicks_select = 'count(*) clicks';
                $pay_out_select = 'AVG(fc.pay_out) payout';
                $cost_select = 'SUM(fc.pay_out) cost';
                break;
            case 4:
                $from = 'log_feed fc';
                $timestamp_select = 'fc.feed_time';
                $clicks_select = 'count(*) clicks';
                $adv_price_select = 'AVG(fc.adv_price) adv_price';
                $revenue_select = 'SUM(fc.adv_price) revenue';
                break;
            case 5:                    //统计redirect match installs
                $from = 'log_feed fc';
                $timestamp_select = 'fc.feed_time';
                $clicks_select = 'count(*) clicks';
                $revenue_select = 'SUM(fc.adv_price) revenue';
                break;
            case 6:                    //统计redirect post
                $from = 'log_post fc';
                $timestamp_select = 'fc.post_time';
                $clicks_select = 'count(*) clicks';
                $cost_select = 'SUM(fc.pay_out) cost';
                break;
        }
        $select = ['fc.campaign_id',
            'fc.channel_id',
            'FROM_UNIXTIME(' . $timestamp_select . ',"%Y-%m-%d %H:00") time',
            'UNIX_TIMESTAMP(FROM_UNIXTIME(' . $timestamp_select . ',"%Y-%m-%d %H:00")) timestamp',
            $clicks_select
        ];
        if (!empty($pay_out_select)) {
            array_push($select, $pay_out_select);
        }
        if (!empty($adv_price_select)) {
            array_push($select, $adv_price_select);
        }
        if (!empty($cost_select)) {
            array_push($select, $cost_select);
        }
        if (!empty($revenue_select)) {
            array_push($select, $revenue_select);
        }
//        Yii::$app->db->createCommand('set time_zone="+8:00"')->execute();
        $query = new Query();
        $query->select($select);
        $query->from($from);
        $query->where(['>=', $timestamp_select, $start_time]);
        $query->andWhere(['<=', $timestamp_select, $end_time]);

        if ($type == 5 || $type == 6) {
            $query->andWhere(['is_redirect' => 1]);
        }

        $query->groupBy(['fc.campaign_id',
            'fc.channel_id',
            'time', 'timestamp']);
        $query->orderBy('timestamp');

        $command = $query->createCommand();
        var_dump($command->sql);
//        die();
        $rows = $command->queryAll();
        foreach ($rows as $item) {
            $channel_id = '';
            $campaign_id = '';
            $timestamp = '';
            $time = '';
            $clicks = '';
            $payout = '';
            $adv_price = '';
            $cost = '';
            $revenue = '';
            foreach ($item as $k => $v) {
                if ($k == 'channel_id') {
                    $channel_id = $v;
                }
                if ($k == 'campaign_id') {
                    $campaign_id = $v;
                }
                if ($k == 'timestamp') {
                    $timestamp = $v;
                }
                if ($k == 'time') {
                    $time = $v;
                }
                if ($k == 'clicks') {
                    $clicks = $v;
                }
                if ($k == 'payout') {
                    $payout = $v;
                }
                if ($k == 'adv_price') {
                    $adv_price = $v;
                }
                if ($k == 'cost') {
                    $cost = $v;
                }
                if ($k == 'revenue') {
                    $revenue = $v;
                }
            }
            $hourly = CampaignLogHourly::findIdentity($campaign_id, $channel_id, $timestamp);
            if (empty($hourly)) {
                $hourly = new CampaignLogHourly();
                $hourly->channel_id = $channel_id;
                $hourly->campaign_id = $campaign_id;
                $hourly->time = $timestamp;
                $hourly->time_format = $time;
            }
            switch ($type) {
                case 1:
                    $hourly->clicks = $clicks;
                    if ($hourly->pay_out == 0 || $hourly->adv_price == 0) {
                        $sts = Deliver::findIdentity($hourly->campaign_id, $hourly->channel_id);
                        if (!empty($sts)) {
                            if ($hourly->pay_out == 0) {
                                $hourly->pay_out = $sts->pay_out;
                            }
                            if ($hourly->adv_price == 0) {
                                $hourly->adv_price = $sts->campaign->adv_price;
                            }
                        }
                    }
                    break;
                case 2:
                    $hourly->unique_clicks = $clicks;
                    break;
                case 3:
                    $hourly->installs = $clicks;
                    $hourly->pay_out = $payout;
                    $hourly->cost = $cost;
                    break;
                case 4:
                    $hourly->match_installs = $clicks;
                    $hourly->adv_price = $adv_price;
                    $hourly->revenue = $revenue;
                    break;
                case 5:
                    $hourly->redirect_match_installs = $clicks;
                    $hourly->redirect_revenue = $revenue;
                    break;
                case 6:
                    $hourly->redirect_installs = $clicks;
                    $hourly->redirect_cost = $cost;
                    break;
            }
            if (!$hourly->save()) {
                var_dump($hourly->getErrors());
            }
        }
    }

    public function updateNullPrice()
    {
        $log = CampaignLogHourly::findNullPrice();
        if (!empty($log)) {
            foreach ($log as $item) {
                $sts = Deliver::findIdentity($item->campaign_id, $item->channel_id);
                if (empty($sts))
                    continue;
                if ($item->pay_out == 0) {
                    $item->pay_out = $sts->pay_out;
                }
                if ($item->adv_price == 0) {
                    $item->adv_price = $sts->campaign->adv_price;
                }
                $item->save();
            }
        }
    }

    public function updateCaps()
    {
        $log = CampaignLogHourly::findNullCap();
        if (!empty($log)) {
            foreach ($log as $item) {
                $sts = Deliver::findIdentity($item->campaign_id, $item->channel_id);
                if (empty($sts))
                    continue;
                if (empty($item->daily_cap)) {
                    $item->daily_cap = $sts->daily_cap;
                }
                if (empty($item->cap)) {
                    $item->cap = $sts->campaign->daily_cap;
                }
                $item->save();
            }
        }
    }

    public function statsFeedHourly($start_time, $end_time)
    {
        date_default_timezone_set("Asia/Shanghai");
        $select = [
            'lf.auth_token',
            'lf.campaign_id',
            'from_unixtime(lf.feed_time, "%y-%m-%d %h:00") time',
            'unix_timestamp( from_unixtime(lf.feed_time, "%y-%m-%d %h:00") ) timestamp',
            'sum(lf.adv_price) revenue',
            'avg(lf.adv_price) adv_price',
            'sum(lp.pay_out) cost'
        ];
        $from = 'log_feed lf';
        $query = new Query();
        $query->select($select);
        $query->from($from);
        $query->leftJoin('log_post lp', 'lf.click_uuid = lp.click_uuid');
        $query->where(['>=', 'lf.feed_time', $start_time]);
        $query->andWhere(['<=', 'lf.feed_time', $end_time]);
        $query->groupBy([
            'lf.auth_token',
            'lf.campaign_id',
            'time',
            'timestamp']);
        $query->orderBy('timestamp');

        $command = $query->createCommand();
        var_dump($command->sql);
        $rows = $command->queryAll();
        foreach ($rows as $item) {
            $time_format = '';
            $timestamp = '';
            $adv_price = '';
            $cost = '';
            $revenue = '';
            $adv_id = '';
            $campaign_id = '';
            foreach ($item as $k => $v) {
                if ($k == 'timestamp') {
                    $timestamp = $v;
                }
                if ($k == 'time') {
                    $time_format = $v;
                }
                if ($k == 'adv_price') {
                    $adv_price = $v;
                }
                if ($k == 'cost') {
                    $cost = $v;
                }
                if ($k == 'revenue') {
                    $revenue = $v;
                }
                if ($k == 'campaign_id') {
                    $campaign_id = $v;
                    $cam = Campaign::findById($v);
                    if (!empty($cam)) {
                        $adv_id = $cam->advertiser;
                    }
                }
            }
            if (empty($adv_id)) {
                continue;
            }
            $hourly = LogFeedHourly::findOne(['adv_id' => $adv_id, 'time' => $timestamp]);
            if (empty($hourly)) {
                $hourly = new LogFeedHourly();
                $hourly->adv_id = $adv_id;
                $hourly->campaign_id = $campaign_id;
                $hourly->time = $timestamp;
            }
            $hourly->time_format = $time_format;
            if (!empty($cost)) {
                $hourly->cost = $cost;
            }
            $hourly->revenue = $revenue;
            $hourly->adv_price = $adv_price;

            if (!$hourly->save()) {
                var_dump($hourly->getErrors());
            }
        }
    }

    public function statsAdvertiserMonthly($start_time, $end_time, $adv_id)
    {
        $select = [
            'cam.advertiser',
            'clh.campaign_id',
            'clh.channel_id',
            'sum(clh.clicks) clicks',
            'sum(clh.unique_clicks) unique_clicks',
            'sum(clh.installs) installs',
            'sum(clh.match_installs) match_installs',
            'sum(clh.redirect_installs) redirect_installs',
            'sum(clh.redirect_match_installs) redirect_match_installs',
            'avg(clh.pay_out) pay_out',
            'avg(clh.adv_price) adv_price',
            'sum(clh.cost) cost',
            'sum(clh.redirect_cost) redirect_cost',
            'sum(clh.revenue) revenue',
            'sum(clh.redirect_revenue) redirect_revenue',
        ];
        $from = 'campaign_log_hourly clh';
        $query = new Query();
        $query->select($select);
        $query->from($from);
        $query->leftJoin('campaign cam', 'cam.id = clh.campaign_id');
        $query->where(['>=', 'clh.time', $start_time]);
        $query->andWhere(['<', 'clh.time', $end_time]);
        $query->andWhere(['cam.advertiser' => $adv_id]);
        $query->groupBy([
            'clh.campaign_id',
            'clh.channel_id',
        ]);
        $query->orderBy('clh.campaign_id');

        $command = $query->createCommand();
//        var_dump($start_time, $end_time, $adv_id);
//        var_dump($command->sql);
//        die();
        $rows = $command->queryAll();
        return $rows;
    }

    public function statsChannelMonthly($start_time, $end_time, $channel_id)
    {
        $select = [
//            'cam.advertiser',
            'clh.campaign_id',
            'clh.channel_id',
            'sum(clh.clicks) clicks',
            'sum(clh.unique_clicks) unique_clicks',
            'sum(clh.installs) installs',
            'sum(clh.match_installs) match_installs',
            'sum(clh.redirect_installs) redirect_installs',
            'sum(clh.redirect_match_installs) redirect_match_installs',
            'avg(clh.pay_out) pay_out',
            'avg(clh.adv_price) adv_price',
            'sum(clh.cost) cost',
            'sum(clh.redirect_cost) redirect_cost',
            'sum(clh.revenue) revenue',
            'sum(clh.redirect_revenue) redirect_revenue',
        ];
        $from = 'campaign_log_hourly clh';
        $query = new Query();
        $query->select($select);
        $query->from($from);
//        $query->leftJoin('campaign cam', 'cam.id = clh.campaign_id');
        $query->where(['>=', 'clh.time', $start_time]);
        $query->andWhere(['<', 'clh.time', $end_time]);
        $query->andWhere(['clh.channel_id' => $channel_id]);
        $query->groupBy([
            'clh.campaign_id',
            'clh.channel_id',
        ]);
        $query->orderBy('clh.campaign_id');

        $command = $query->createCommand();
        $rows = $command->queryAll();
        return $rows;
    }

    public function statsSubChannelHourly($type, $start_time, $end_time)
    {
        date_default_timezone_set("Asia/Shanghai");
        $from = 'log_click fc';
        $clicks_select = 'count(*) clicks';
        $timestamp_select = 'fc.create_time';
        $pay_out_select = '';
        $adv_price_select = '';
        $cost_select = '';
        $revenue_select = '';
        switch ($type) {
            case 1:
                $from = 'log_click fc';
                $clicks_select = 'count(*) clicks';
                break;
            case 2:
                $from = 'log_click fc';
                $clicks_select = 'count(distinct(fc.ip_long)) clicks';
                break;
            case 3:
                $from = 'log_post fc';
                $timestamp_select = 'fc.post_time';
                $clicks_select = 'count(*) clicks';
                $pay_out_select = 'AVG(fc.pay_out) payout';
                $cost_select = 'SUM(fc.pay_out) cost';
                break;
            case 4:
                $from = 'log_feed fc';
                $timestamp_select = 'fc.feed_time';
                $clicks_select = 'count(*) clicks';
                $adv_price_select = 'AVG(fc.adv_price) adv_price';
                $revenue_select = 'SUM(fc.adv_price) revenue';
                break;
            case 5:                    //统计redirect match installs
                $from = 'log_feed fc';
                $timestamp_select = 'fc.feed_time';
                $clicks_select = 'count(*) clicks';
                $revenue_select = 'SUM(fc.adv_price) revenue';
                break;
            case 6:                    //统计redirect post
                $from = 'log_post fc';
                $timestamp_select = 'fc.post_time';
                $clicks_select = 'count(*) clicks';
                $cost_select = 'SUM(fc.pay_out) cost';
                break;
        }
        $select = ['fc.campaign_id',
            'fc.channel_id',
            'fc.ch_subid',
            'FROM_UNIXTIME(' . $timestamp_select . ',"%Y-%m-%d %H:00") time',
            'UNIX_TIMESTAMP(FROM_UNIXTIME(' . $timestamp_select . ',"%Y-%m-%d %H:00")) timestamp',
            $clicks_select
        ];
        if (!empty($pay_out_select)) {
            array_push($select, $pay_out_select);
        }
        if (!empty($adv_price_select)) {
            array_push($select, $adv_price_select);
        }
        if (!empty($cost_select)) {
            array_push($select, $cost_select);
        }
        if (!empty($revenue_select)) {
            array_push($select, $revenue_select);
        }
        Yii::$app->db->createCommand('set time_zone="+8:00"')->execute();
        $query = new Query();
        $query->select($select);
        $query->from($from);
        $query->where(['>=', $timestamp_select, $start_time]);
        $query->andWhere(['<=', $timestamp_select, $end_time]);

        if ($type == 5 || $type == 6) {
            $query->andWhere(['is_redirect' => 1]);
        }

        $query->groupBy(['fc.campaign_id',
            'fc.channel_id',
            'fc.ch_subid',
            'time', 'timestamp']);
        $query->orderBy('timestamp');

        $command = $query->createCommand();
        var_dump($command->sql);
//        die();
        $rows = $command->queryAll();
        foreach ($rows as $item) {
            $channel_id = '';
            $campaign_id = '';
            $sub_channel_id = '';
            $timestamp = '';
            $time = '';
            $clicks = '';
            $payout = '';
            $adv_price = '';
            $cost = '';
            $revenue = '';
            foreach ($item as $k => $v) {
                if ($k == 'channel_id') {
                    $channel_id = $v;
                }
                if ($k == 'campaign_id') {
                    $campaign_id = $v;
                }
                if ($k == 'ch_subid') {
                    $sub_channel_id = $v;
                }
                if ($k == 'timestamp') {
                    $timestamp = $v;
                }
                if ($k == 'time') {
                    $time = $v;
                }
                if ($k == 'clicks') {
                    $clicks = $v;
                }
                if ($k == 'payout') {
                    $payout = $v;
                }
                if ($k == 'adv_price') {
                    $adv_price = $v;
                }
                if ($k == 'cost') {
                    $cost = $v;
                }
                if ($k == 'revenue') {
                    $revenue = $v;
                }
            }
            $hourly = CampaignLogSubChannelHourly::findIdentity($campaign_id, $channel_id, $sub_channel_id, $timestamp);
            if (empty($hourly)) {
                $hourly = new CampaignLogSubChannelHourly();
                $hourly->channel_id = $channel_id;
                $hourly->campaign_id = $campaign_id;
                $hourly->sub_channel = $sub_channel_id;
                $hourly->time = $timestamp;
                $hourly->time_format = $time;
            }
            switch ($type) {
                case 1:
                    $hourly->clicks = $clicks;
                    if ($hourly->pay_out == 0 || $hourly->adv_price == 0) {
                        $sts = Deliver::findIdentity($hourly->campaign_id, $hourly->channel_id);
                        if (!empty($sts)) {
                            if ($hourly->pay_out == 0) {
                                $hourly->pay_out = $sts->pay_out;
                            }
                            if ($hourly->adv_price == 0) {
                                $hourly->adv_price = $sts->campaign->adv_price;
                            }
                        }
                    }
                    break;
                case 2:
                    $hourly->unique_clicks = $clicks;
                    break;
                case 3:
                    $hourly->installs = $clicks;
                    $hourly->pay_out = $payout;
                    $hourly->cost = $cost;
                    break;
                case 4:
                    $hourly->match_installs = $clicks;
                    $hourly->adv_price = $adv_price;
                    $hourly->revenue = $revenue;
                    break;
                case 5:
                    $hourly->redirect_match_installs = $clicks;
                    $hourly->redirect_revenue = $revenue;
                    break;
                case 6:
                    $hourly->redirect_installs = $clicks;
                    $hourly->redirect_cost = $cost;
                    break;
            }
            if (!$hourly->save()) {
                var_dump($hourly->getErrors());
            }
        }
    }

    public function statsSubChannelClickHourly($start_time, $end_time)
    {
        $this->statsSubChannelHourly(1, $start_time, $end_time);
    }

    public function statsSubChannelUniqueClickHourly($start_time, $end_time)
    {
        $this->statsSubChannelHourly(2, $start_time, $end_time);
    }

    public function statsSubChannelMatchInstallHourly($start_time, $end_time)
    {
        $this->statsSubChannelHourly(4, $start_time, $end_time);
    }

    public function statsSubChannelInstallHourly($start_time, $end_time)
    {
        $this->statsSubChannelHourly(3, $start_time, $end_time);
    }

    public function statsSubChannelRedirectInstallHourly($start_time, $end_time)
    {
        $this->statsSubChannelHourly(6, $start_time, $end_time);
    }

    public function statsSubChannelRedirectMatchInstallHourly($start_time, $end_time)
    {
        $this->statsSubChannelHourly(5, $start_time, $end_time);
    }

    /**
     * @param $start_time
     */
    public function checkCvr($start_time)
    {
        echo "Check CVR" . PHP_EOL;
        if ($start_time > 0) {
            $start_time = $this->getBeforeTwoHours($start_time);
        }

        $logs = CampaignLogHourly::find()->where(['>=', 'time', $start_time])->all();
        if (!empty($logs)) {
            foreach ($logs as $log) {
                if ($log->match_installs > 10) { // match cvr > 10
                    $camp = Campaign::findById($log->campaign_id);
                    if (!empty($camp)) {
                        $traffic_source = $camp->traffic_source;
                        echo $traffic_source . PHP_EOL;
                        if (strpos($traffic_source, 'incent') !== 0) { // non-incent
                            echo "camp-" . $camp->id . PHP_EOL;
                            if ($log->clicks == 0) {
                                continue;
                            }
                            $cvr = ($log->match_installs / $log->clicks) * 100;
                            $sts = Deliver::findIdentity($camp->id, $log->channel_id);
                            if ($sts->status == 1) {
                                if ($cvr > 3) {
                                    $check = LogAutoCheck::find()->andWhere(['campaign_id' => $camp->id, 'channel_id' => $sts->channel_id,])
                                        ->andWhere(['>', 'match_cvr', 3])->andWhere(['>', 'create_time', strtotime('today')])->one();
                                } else if ($cvr > 1.5) {
                                    $old_discount = $sts->discount;
                                    if ($old_discount != 99) {
                                        $check = LogAutoCheck::find()->andWhere(['campaign_id' => $camp->id, 'channel_id' => $sts->channel_id,])
                                            ->andFilterWhere(['between', 'match_cvr', 1.5, 3])->andWhere(['>', 'create_time', strtotime('today')])->one();
                                    }
                                }

                                if (empty($check)){
                                    $check = new LogAutoCheck();
                                }else{
                                    continue;
                                }
//                                var_dump($sts->channel->username);
                                $check->campaign_id = $camp->id;
                                $check->channel_id = $sts->channel_id;
                                $check->campaign_name = $camp->campaign_name;
                                $check->channel_name = (empty($sts->channel)?null:$sts->channel->username);
                                $check->match_cvr = $cvr;
                                $check->match_install = $log->match_installs;
                                $check->type = 1;

                                if ($cvr > 3) {
                                    $sts->status = 2;
                                    $check->action = 'pause';
//                                    $sts->save();
                                    $check->save();
                                    echo "deliver pause-" . $camp->id . "-" . $sts->channel_id . PHP_EOL;
                                } else if ($cvr > 1.5) {
                                    $old_discount = $sts->discount;
                                    if ($old_discount != 99) {
                                        echo "deliver discount-" . $camp->id . "-" . $sts->channel_id . " set from " . $sts->discount . " to 99" . PHP_EOL;
                                        $sts->discount = 99;
//                                        $sts->save();
                                        $check->action = '99%discount';
                                        $check->save();
                                    }
                                }
                            }

                        }
                    }
                }
            }
        }

        // send mail
        $sendings = LogAutoCheck::findAll(['is_send' => 0, 'type' => 1]);
        if (!empty($sendings)) {
            MailUtil::autoCheckCvr($sendings);
        }
    }

    /**
     * @param $start_time
     * @return int
     */
    public function getBeforeTwoHours($start_time){
        $datetime = new \DateTime();
        $datetime->setTimestamp($start_time);
        echo $datetime->format('Y-m-d H:i:s');

        $interval = new \DateInterval('P0DT2H');
        $datetime->sub($interval);

        echo $datetime->format('Y-m-d H:i:s');
        $start_time = $datetime->getTimestamp();

        return $start_time;
    }

    public function checkCap()
    {
        echo "Check CAP" . PHP_EOL;
        $logs = CampaignLogHourly::getCurrentDay();
        if (!empty($logs)) {
            foreach ($logs as $log) {
                $log = json_decode(json_encode($log));
                $check = LogAutoCheck::find()->where(['campaign_id' => $log->campaign_id, 'channel_id' => $log->channel_id])->andWhere(['>', 'create_time', strtotime('today')])->one();
                if (empty($check)) {
                    $check = new LogAutoCheck();
                    if ($log->clicks == 0) {
                        continue;
                    }
                    $cvr = ($log->match_installs / $log->clicks) * 100;
                    $check->match_cvr = $cvr;
                    $check->campaign_id = $log->campaign_id;
                    $check->channel_id = $log->channel_id;
                    $check->campaign_name = $log->campaign_name;
                    $check->channel_name = $log->channel_name;
                    $check->installs = $log->installs;
                    $check->match_install = $log->match_installs;
                    $check->daily_cap = $log->daily_cap;
                    $check->type = 2;
                    if ($cvr > 1.5) {
                        $check->action = 'pause';
                        $check->save();
                        echo "deliver pause-" . $log->campaign_id . "-" . $log->channel_id . PHP_EOL;
                    } else if ($cvr < 1.5) {
                        echo "deliver discount-" . $log->campaign_id . "-" . $log->channel_id  . PHP_EOL;
                        $check->action = '99%discount';
                        $check->save();
                    }
                }
            }
        }

        // send mail
        $sendings = LogAutoCheck::findAll(['is_send' => 0, 'type' => 2]);
        if (!empty($sendings)) {
            MailUtil::autoCheckCap($sendings);
        }
    }

    public function statsClicksHourly($start_time, $end_time)
    {
        $from = 'log_click fc';
        $timestamp_select = 'fc.create_time';
//                $from = 'log_click fc';
//                $clicks_select = 'count(distinct(fc.ip_long)) clicks';
        $select = ['fc.campaign_id',
            'fc.channel_id',
            'FROM_UNIXTIME(' . $timestamp_select . ',"%Y-%m-%d %H:00") time',
            'UNIX_TIMESTAMP(FROM_UNIXTIME(' . $timestamp_select . ',"%Y-%m-%d %H:00")) timestamp',
            'count(*) clicks',
            'count(distinct(fc.ip_long)) uclicks'
        ];
        $query = new Query();
        $query->select($select);
        $query->from($from);
        $query->where(['>=', $timestamp_select, $start_time]);
        $query->andWhere(['<', $timestamp_select, $end_time]);


        $query->groupBy(['fc.campaign_id',
            'fc.channel_id',
            'timestamp']);
        $query->orderBy('timestamp desc');

        $command = $query->createCommand();
        var_dump($command->sql);
//        die();
        $rows = $command->queryAll();
        var_dump($rows);
        foreach ($rows as $item) {
            $channel_id = '';
            $campaign_id = '';
            $timestamp = '';
            $time = '';
            $clicks = '';
            $uclicks = '';
            foreach ($item as $k => $v) {
                if ($k == 'channel_id') {
                    $channel_id = $v;
                }
                if ($k == 'campaign_id') {
                    $campaign_id = $v;
                }
                if ($k == 'timestamp') {
                    $timestamp = $v;
                }
                if ($k == 'time') {
                    $time = $v;
                }
                if ($k == 'clicks') {
                    $clicks = $v;
                }
                if ($k == 'uclicks') {
                    $uclicks = $v;
                }
            }
            $hourly = CampaignLogHourly::findIdentity($campaign_id, $channel_id, $timestamp);
            if (empty($hourly)) {
                $hourly = new CampaignLogHourly();
                $hourly->channel_id = $channel_id;
                $hourly->campaign_id = $campaign_id;
                $hourly->time = $timestamp;
                $hourly->time_format = $time;
                $hourly->clicks = $clicks;
                $hourly->unique_clicks = $uclicks;
            } else {
                $hourly->clicks += $clicks;
                $hourly->unique_clicks += $uclicks;
            }
            if ($hourly->pay_out == 0 || $hourly->adv_price == 0) {
                $sts = Deliver::findIdentity($hourly->campaign_id, $hourly->channel_id);
                if (!empty($sts)) {
                    if ($hourly->pay_out == 0) {
                        $hourly->pay_out = $sts->pay_out;
                    }
                    if ($hourly->adv_price == 0) {
                        $hourly->adv_price = $sts->campaign->adv_price;
                    }
                }
            }
            echo $hourly->campaign_id . '-' . $hourly->channel_id . '-' . $hourly->time_format . '-' . $hourly->clicks . '-' . $hourly->unique_clicks . "\n";
            if (!$hourly->save()) {
                var_dump($hourly->getErrors());
            }
        }
    }

    public function statsSubClicksHourly($start_time, $end_time)
    {
        $from = 'log_click fc';
        $timestamp_select = 'fc.create_time';
//                $from = 'log_click fc';
//                $clicks_select = 'count(distinct(fc.ip_long)) clicks';
        $select = ['fc.campaign_id',
            'fc.channel_id',
            'fc.ch_subid',
            'FROM_UNIXTIME(' . $timestamp_select . ',"%Y-%m-%d %H:00") time',
            'UNIX_TIMESTAMP(FROM_UNIXTIME(' . $timestamp_select . ',"%Y-%m-%d %H:00")) timestamp',
            'count(*) clicks',
            'count(distinct(fc.ip_long)) uclicks'
        ];
        $query = new Query();
        $query->select($select);
        $query->from($from);
        $query->where(['>=', $timestamp_select, $start_time]);
        $query->andWhere(['<', $timestamp_select, $end_time]);


        $query->groupBy(['fc.campaign_id',
            'fc.channel_id',
            'fc.ch_subid',
            'timestamp']);
        $query->orderBy('timestamp desc');

        $command = $query->createCommand();
        var_dump($command->sql);
//        die();
        $rows = $command->queryAll();
        var_dump($rows);
        foreach ($rows as $item) {
            $channel_id = '';
            $campaign_id = '';
            $sub_channel_id = '';
            $timestamp = '';
            $time = '';
            $clicks = '';
            $uclicks = '';
            foreach ($item as $k => $v) {
                if ($k == 'channel_id') {
                    $channel_id = $v;
                }
                if ($k == 'campaign_id') {
                    $campaign_id = $v;
                }
                if ($k == 'ch_subid') {
                    $sub_channel_id = $v;
                }
                if ($k == 'timestamp') {
                    $timestamp = $v;
                }
                if ($k == 'time') {
                    $time = $v;
                }
                if ($k == 'clicks') {
                    $clicks = $v;
                }
                if ($k == 'uclicks') {
                    $uclicks = $v;
                }
            }
            $hourly = CampaignLogSubChannelHourly::findIdentity($campaign_id, $channel_id, $sub_channel_id, $timestamp);
            if (empty($hourly)) {
                $hourly = new CampaignLogSubChannelHourly();
                $hourly->channel_id = $channel_id;
                $hourly->campaign_id = $campaign_id;
                $hourly->sub_channel = $sub_channel_id;
                $hourly->time = $timestamp;
                $hourly->time_format = $time;
                $hourly->clicks = $clicks;
                $hourly->unique_clicks = $uclicks;
            } else {
                $hourly->clicks += $clicks;
                $hourly->unique_clicks += $uclicks;
            }
            if ($hourly->pay_out == 0 || $hourly->adv_price == 0) {
                $sts = Deliver::findIdentity($hourly->campaign_id, $hourly->channel_id);
                if (!empty($sts)) {
                    if ($hourly->pay_out == 0) {
                        $hourly->pay_out = $sts->pay_out;
                    }
                    if ($hourly->adv_price == 0) {
                        $hourly->adv_price = $sts->campaign->adv_price;
                    }
                }
            }
            echo $hourly->campaign_id . '-' . $hourly->channel_id .$hourly->sub_channel. '-' . $hourly->time_format . '-' . $hourly->clicks . '-' . $hourly->unique_clicks . "\n";
            if (!$hourly->save()) {
                var_dump($hourly->getErrors());
            }
        }
    }
}