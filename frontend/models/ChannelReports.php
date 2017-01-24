<?php
/**
 * Created by PhpStorm.
 * User: Iven.Wu
 * Date: 2017-01-24
 * Time: 16:03
 */

namespace frontend\models;


use common\models\Deliver;
use yii\db\Query;

class ChannelReports extends Deliver
{
    public $daily_click;
    public $daily;
    public $hourly;
    public $hourly_click;
    public $start_time;
    public $end_time;
    public $timezone;

    public static function getDailyReport($start_time, $end_time)
    {
        /**
         *
         * SELECT
         * count(a.id),
         * a.ch_id,
         * b.*,
         * FROM_UNIXTIME(a.create_time, '%Y-%m-%d %H')
         * FROM
         * feedback_channel_click_log a LEFT JOIN campaign b on a.cp_uid = b.campaign_uuid
         * GROUP BY
         * FROM_UNIXTIME(a.create_time, '%Y-%m-%d %H')
         * HAVING
         * a.ch_id = 29
         * ORDER BY
         * a.ch_id;
         */
        $rows = ChannelReports::find();
//        var_dump($rows);
//        die();
        $rows->select(['count(a.id) daily_click', 'FROM_UNIXTIME(a.create_time, "%Y-%m-%d %H") daily', 'a.ch_id channel_id', 'b.*']);
        $rows->from('feedback_channel_click_log a');
        $rows->leftJoin('campaign b', 'a.cp_uid = b.campaign_uuid');
        $rows->groupBy('daily');
        $rows->having('channel_id = 29');
        $rows->orderBy('channel_id');
        return $rows->all();
    }
}