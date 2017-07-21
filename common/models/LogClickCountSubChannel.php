<?php

namespace common\models;

use UrbanIndo\Yii2\DynamoDb\ActiveRecord;
use Yii;

/**
 * This is the model class for table "log_click_count_sub_channel".
 *
 * @property integer $campaign_channel_sub_time
 * @property integer $clicks
 * @property integer $unique_clicks
 * @property integer $time
 */
class LogClickCountSubChannel extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_click_count_sub_channel';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign_channel_sub_time', 'time'], 'required'],
            [['campaign_channel_sub_time', 'clicks', 'unique_clicks', 'time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            'campaign_channel_sub_time',
            'clicks',
            'unique_clicks',
            'time',
        ];
    }

    /**
     * @param $campaign_channel
     * @param $sub
     * @param int $time
     * @param bool $unique_click
     * @return LogClickCount
     */
    public static function updateCampaignClick($campaign_channel, $sub, $time, $unique_click = false)
    {
        $key = $campaign_channel . '_' . $sub . '_' . $time;
        if ($unique_click == true) {
            self::updateAllCounters(['clicks' => 1, 'unique_clicks' => 1], ['campaign_channel_sub_time' => $key, 'time' => $time]);
        } else {
            self::updateAllCounters(['clicks' => 1], ['campaign_channel_sub_time' => $key, 'time' => $time]);
        }
    }
}
