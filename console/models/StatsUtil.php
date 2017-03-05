<?php
/**
 * Created by PhpStorm.
 * User: iven.wu
 * Date: 3/2/2017
 * Time: 9:56 PM
 */

namespace console\models;


use common\models\CampaignLogDaily;
use common\models\CampaignLogHourly;
use common\models\Config;
use Yii;
use yii\db\Query;

class StatsUtil
{

    public function statsClickHourly()
    {
        $this->statsHourly(1);
    }

    public function statsUniqueClickHourly()
    {
        $this->statsHourly(2);
    }

    public function statsMatchInstallHourly()
    {
        $this->statsHourly(4);
    }

    public function statsInstallHourly()
    {
        $this->statsHourly(3);
    }

    public function statsDaily()
    {
        date_default_timezone_set("Asia/Shanghai");
        $end_time = strtotime(date("Y-m-d", time()));
        $start_time = Config::findLastStatsDaily();
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
        $query->andWhere(['<', 'time', $end_time]);

        $query->groupBy(['clh.campaign_id',
            'clh.channel_id',
            'timeformat', 'timestamp']);
        $query->orderBy('timestamp');

        $command = $query->createCommand();
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
        Config::updateStatsTimeDaily($end_time);
    }

    public function statsHourly($type)
    {
        date_default_timezone_set("Asia/Shanghai");
        $from = 'log_click fc';
        $clicks_select = 'count(*) clicks';
        $timestamp_select = 'fc.click_time';
        $end_time = strtotime(date("Y-m-d H:00", time()));
        $start_time = Config::findLastStatsHourly($type);
        $pay_out_select = '';
        $adv_price_select = '';
        switch ($type) {
            case 1:
                $from = 'log_click fc';
                $clicks_select = 'count(*) clicks';
                $pay_out_select = 'AVG(fc.pay_out) payout';
                break;
            case 2:
                $from = 'log_click fc';
                $clicks_select = 'count(distinct(fc.ip)) clicks';
                break;
            case 3:
                $from = 'log_post fc';
                $timestamp_select = 'fc.post_time';
                $clicks_select = 'count(*) clicks';
                break;
            case 4:
                $from = 'log_feed fc';
                $timestamp_select = 'fc.feed_time';
                $clicks_select = 'count(*) clicks';
                $adv_price_select = 'AVG(adv_price) adv_price';
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
        Yii::$app->db->createCommand('set time_zone="+8:00"')->execute();
        $query = new Query();
        $query->select($select);
        $query->from($from);
        $query->where(['>=', $timestamp_select, $start_time]);
        $query->andWhere(['<', $timestamp_select, $end_time]);

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
                    $hourly->pay_out = $payout;
                    break;
                case 2:
                    $hourly->unique_clicks = $clicks;
                    break;
                case 3:
                    $hourly->installs = $clicks;
                    break;
                case 4:
                    $hourly->match_installs = $clicks;
                    $hourly->adv_price = $adv_price;
                    break;
            }
            if (!$hourly->save()) {
                var_dump($hourly->getErrors());
            }
        }
        Config::updateStatsTimeHourly($type, $end_time);
    }
}