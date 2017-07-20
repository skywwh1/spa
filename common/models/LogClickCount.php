<?php

namespace common\models;

use UrbanIndo\Yii2\DynamoDb\ActiveRecord;
use UrbanIndo\Yii2\DynamoDb\Query;
use Yii;

/**
 * This is the model class for table "log_click_count".
 *
 * @property integer $campaign_channel_time
 * @property integer $clicks
 * @property integer $unique_clicks
 * @property integer $time
 */
class LogClickCount extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_click_count';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign_channel_time', 'time'], 'required'],
            [['campaign_channel_time', 'clicks', 'unique_clicks', 'time'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            'campaign_channel_time',
            'time',
            'clicks',
            'unique_clicks',
        ];
    }

    /**
     * @param $campaign_channel
     * @param int $time
     * @param bool $unique_click
     * @return LogClickCount
     */
    public static function updateCampaignClick($campaign_channel, $time, $unique_click = false)
    {
        $key = $campaign_channel . '_' . $time;
        if ($unique_click == true) {
            self::updateAllCounters(['clicks' => 1, 'unique_clicks' =>1], ['campaign_channel_time' => $key,'time'=>$time]);
        } else {
            self::updateAllCounters(['clicks' => 1], ['campaign_channel_time' => $key,'time'=>$time]);
        }
    }

}
