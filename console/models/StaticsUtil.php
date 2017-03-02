<?php
/**
 * Created by PhpStorm.
 * User: iven.wu
 * Date: 3/2/2017
 * Time: 9:56 PM
 */

namespace console\models;


use common\models\CampaignLogHourly;
use Yii;
use yii\db\Query;

class StaticsUtil
{

    public function staticClickHourly()
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
            'count(fc.id) clicks']);
        $query->from('log_click fc');
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
                $hourly->clicks = $clicks;
            } else {
                $hourly->clicks = $clicks;
            }

            $hourly->save();
            var_dump($hourly->getErrors());
        }
    }

    public function staticUniqueClickHourly()
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

    public function staticMatchInstallHourly()
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

    public function staticPostHourly()
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

}