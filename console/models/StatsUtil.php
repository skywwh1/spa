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
        Yii::$app->db->createCommand('set time_zone="+8:00"')->execute();
        date_default_timezone_set("Asia/Shanghai");
        $query = new Query();
        $query->select(['fc.campaign_id',
            'fc.channel_id',
            'FROM_UNIXTIME(fc.click_time,"%Y-%m-%d %H:00") time',
            'UNIX_TIMESTAMP(FROM_UNIXTIME(
                fc.click_time,
                "%Y-%m-%d %H:00"
            )) timestamp',
            'count(distinct(fc.ip)) clicks']);
        $query->from('log_click fc');
        $query->groupBy(['fc.campaign_id',
            'fc.channel_id',
            'time', 'timestamp']);
        $query->orderBy('timestamp');

        $command = $query->createCommand();
        var_dump($command->sql);
        die();
        $rows = $command->queryAll();

        foreach ($rows as $item) {
            $channel_id = '';
            $campaign_id = '';
            $timestamp = '';
            $time = '';
            $clicks = '';
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
            }
            $hourly = CampaignLogHourly::findIdentity($campaign_id, $channel_id, $timestamp);
            if (empty($hourly)) {
                $hourly = new CampaignLogHourly();
                $hourly->channel_id = $channel_id;
                $hourly->campaign_id = $campaign_id;
                $hourly->time = $timestamp;
                $hourly->time_format = $time;
                $hourly->unique_clicks = $clicks;
            } else {
                $hourly->unique_clicks = $clicks;
            }

            $hourly->save();
            var_dump($hourly->getErrors());
        }
    }

    public function statsMatchInstallHourly()
    {
        Yii::$app->db->createCommand('set time_zone="+8:00"')->execute();
        date_default_timezone_set("Asia/Shanghai");
        $query = new Query();
        $query->select(['fc.campaign_id',
            'fc.channel_id',
            'FROM_UNIXTIME(fc.feed_time,"%Y-%m-%d %H:00") time',
            'UNIX_TIMESTAMP(FROM_UNIXTIME(
                fc.feed_time,
                "%Y-%m-%d %H:00"
            )) timestamp',
            'count(*) clicks']);
        $query->from('log_feed fc');
        $query->groupBy(['fc.campaign_id',
            'fc.channel_id',
            'time', 'timestamp']);
        $query->orderBy('timestamp');

        $command = $query->createCommand();
        $rows = $command->queryAll();

        foreach ($rows as $item) {
            $channel_id = '';
            $campaign_id = '';
            $timestamp = '';
            $time = '';
            $clicks = '';
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
            }
            $hourly = CampaignLogHourly::findIdentity($campaign_id, $channel_id, $timestamp);
            if (empty($hourly)) {
                $hourly = new CampaignLogHourly();
                $hourly->channel_id = $channel_id;
                $hourly->campaign_id = $campaign_id;
                $hourly->time = $timestamp;
                $hourly->time_format = $time;
                $hourly->match_installs = $clicks;
            } else {
                $hourly->match_installs = $clicks;
            }

            $hourly->save();
            var_dump($hourly->getErrors());
        }
    }

    public function statsPostHourly()
    {
        Yii::$app->db->createCommand('set time_zone="+8:00"')->execute();
        date_default_timezone_set("Asia/Shanghai");
        $query = new Query();
        $query->select(['fc.campaign_id',
            'fc.channel_id',
            'FROM_UNIXTIME(fc.post_time,"%Y-%m-%d %H:00") time',
            'UNIX_TIMESTAMP(FROM_UNIXTIME(
                fc.post_time,
                "%Y-%m-%d %H:00"
            )) timestamp',
            'count(*) clicks']);
        $query->from('log_post fc');
        $query->groupBy(['fc.campaign_id',
            'fc.channel_id',
            'time', 'timestamp']);
        $query->orderBy('timestamp');

        $command = $query->createCommand();
        $rows = $command->queryAll();

        foreach ($rows as $item) {
            $channel_id = '';
            $campaign_id = '';
            $timestamp = '';
            $time = '';
            $clicks = '';
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
            }
            $hourly = CampaignLogHourly::findIdentity($campaign_id, $channel_id, $timestamp);
            if (empty($hourly)) {
                $hourly = new CampaignLogHourly();
                $hourly->channel_id = $channel_id;
                $hourly->campaign_id = $campaign_id;
                $hourly->time = $timestamp;
                $hourly->time_format = $time;
                $hourly->installs = $clicks;
            } else {
                $hourly->installs = $clicks;
            }

            $hourly->save();
            var_dump($hourly->getErrors());
        }
    }

//SELECT
//clh.campaign_id,
//clh.channel_id,
//FROM_UNIXTIME(clh.time, "%Y-%m-%d") timeformat,
//SUM(clh.clicks) clicks
//FROM
//campaign_log_hourly clh
//GROUP BY
//clh.campaign_id,
//clh.channel_id,
//timeformat
    public function statsClickDaily()
    {
        $this->statsDaily(1);
    }

    public function statsUniqueClickDaily()
    {
        $this->statsDaily(2);
    }

    public function statsInstallDaily()
    {
        $this->statsDaily(3);
    }

    public function statsMatchInstallDaily()
    {
        $this->statsDaily(4);
    }

    public function statsDaily($type)
    {
        $sum = 'SUM(clh.clicks) clicks';
        switch ($type) {
            case 1:
                $sum = 'SUM(clh.clicks) clicks';
                break;
            case 2:
                $sum = 'SUM(clh.unique_clicks) clicks';
                break;
            case 3:
                $sum = 'SUM(clh.installs) clicks';
                break;
            case 4:
                $sum = 'SUM(clh.match_installs) clicks';
                break;

        }

        Yii::$app->db->createCommand('set time_zone="+8:00"')->execute();
        date_default_timezone_set("Asia/Shanghai");
        $query = new Query();
        $query->select(['clh.campaign_id',
            'clh.channel_id',
            'FROM_UNIXTIME(clh.time,"%Y-%m-%d") timeformat',
            'UNIX_TIMESTAMP(FROM_UNIXTIME(
                clh.time,
                "%Y-%m-%d"
            )) timestamp',
            $sum]);
        $query->from('campaign_log_hourly clh');
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

            }
            $hourly = CampaignLogDaily::findIdentity($campaign_id, $channel_id, $timestamp);
            if (empty($hourly)) {
                $hourly = new CampaignLogDaily();
                $hourly->channel_id = $channel_id;
                $hourly->campaign_id = $campaign_id;
                $hourly->time = $timestamp;
                $hourly->time_format = $time;
            }
            switch ($type) {
                case 1:
                    $hourly->clicks = $clicks;
                    break;
                case 2:
                    $hourly->unique_clicks = $clicks;
                    break;
                case 3:
                    $hourly->installs = $clicks;
                    break;
                case 4:
                    $hourly->match_installs = $clicks;
                    break;

            }
            $hourly->save();
            var_dump($hourly->getErrors());
        }
    }

    public function statsHourly($type)
    {
        $from = 'log_click fc';
        $time = 'FROM_UNIXTIME(fc.click_time,"%Y-%m-%d %H:00") time';
        $clicks_select = 'count(*) clicks';
        switch ($type) {
            case 1:
                $from = 'log_click fc';
                $time = 'FROM_UNIXTIME(fc.click_time,"%Y-%m-%d %H:00") time';
                $clicks_select = 'count(*) clicks';
                break;
            case 2:
                $from = 'log_click fc';
                $time = 'FROM_UNIXTIME(fc.click_time,"%Y-%m-%d %H:00") time';
                $clicks_select = 'count(distinct(fc.ip)) clicks';
                break;
            case 3:
                $from = 'log_post fc';
                $time = 'FROM_UNIXTIME(fc.post_time,"%Y-%m-%d %H:00") time';
                $clicks_select = 'count(*) clicks';
                break;
            case 4:
                $from = 'log_feed fc';
                $time = 'FROM_UNIXTIME(fc.feed_time,"%Y-%m-%d %H:00") time';
                $clicks_select = 'count(*) clicks';
                break;
        }

        Yii::$app->db->createCommand('set time_zone="+8:00"')->execute();
        date_default_timezone_set("Asia/Shanghai");
        $query = new Query();
        $query->select(['fc.campaign_id',
            'fc.channel_id', $time
            ,
            'UNIX_TIMESTAMP(FROM_UNIXTIME(
                fc.click_time,
                "%Y-%m-%d %H:00"
            )) timestamp',
            $clicks_select]);
        $query->from($from);
        $query->groupBy(['fc.campaign_id',
            'fc.channel_id',
            'time', 'timestamp']);
        $query->orderBy('timestamp');

        $command = $query->createCommand();
        var_dump($command->sql);
        die();
        $rows = $command->queryAll();

        foreach ($rows as $item) {
            $channel_id = '';
            $campaign_id = '';
            $timestamp = '';
            $time = '';
            $clicks = '';
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
                    break;
                case 2:
                    $hourly->unique_clicks = $clicks;
                    break;
                case 3:
                    $hourly->installs = $clicks;
                    break;
                case 4:
                    $hourly->match_installs = $clicks;
                    break;
            }


            $hourly->save();
            var_dump($hourly->getErrors());
        }
    }
}