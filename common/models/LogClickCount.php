<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "log_click_count".
 *
 * @property integer $campaign_id
 * @property integer $channel_id
 * @property integer $clicks
 * @property integer $unique_clicks
 * @property integer $time
 */
class LogClickCount extends \yii\db\ActiveRecord
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
            [['campaign_id', 'channel_id', 'time'], 'required'],
            [['campaign_id', 'channel_id', 'clicks', 'unique_clicks', 'time'], 'integer'],
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
            'clicks' => 'Clicks',
            'unique_clicks' => 'Unique Clicks',
            'time' => 'Time',
        ];
    }


    /**
     * @param $campaign_id
     * @param $channel_id
     * @param int $time
     * @return LogClickCount
     */
    public static function findCampaignClick($campaign_id, $channel_id, $time)
    {
        $click = static::findOne(['campaign_id' => $campaign_id, 'channel_id' => $channel_id, 'time' => $time]);
        if (empty($click)) {
            $click = new LogClickCount();
            $click->campaign_id = $campaign_id;
            $click->channel_id = $channel_id;
            $click->time = $time;
            $click->save();
        }
        return $click;
    }

}
