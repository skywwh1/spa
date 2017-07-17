<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "log_click_count_sub_channel".
 *
 * @property integer $campaign_id
 * @property integer $channel_id
 * @property string $sub_channel
 * @property integer $clicks
 * @property integer $unique_clicks
 * @property integer $time
 */
class LogClickCountSubChannel extends \yii\db\ActiveRecord
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
            [['campaign_id', 'channel_id', 'clicks', 'unique_clicks', 'time'], 'integer'],
            [['sub_channel'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'campaign_id' => 'Campaign ID',
            'channel_id' => 'Channel ID',
            'sub_channel' => 'Sub Channel',
            'clicks' => 'Clicks',
            'unique_clicks' => 'Unique Clicks',
            'time' => 'Time',
        ];
    }

    /**
     * @param $campaign_id
     * @param $channel_id
     * @param $sub_channel
     * @param int $time
     * @return LogClickCountSubChannel
     */
    public static function findCampaignSubClick($campaign_id, $channel_id, $sub_channel, $time)
    {
        if(empty($sub_channel)){
            return null;
        }
        $click = static::findOne(['campaign_id' => $campaign_id, 'channel_id' => $channel_id, 'sub_channel' => $sub_channel, 'time' => $time]);
        if (empty($click)) {
            $click = new LogClickCountSubChannel();
            $click->campaign_id = $campaign_id;
            $click->channel_id = $channel_id;
            $click->sub_channel = $sub_channel;
            $click->time = $time;
            $click->save();
        }
        return $click;
    }
}
