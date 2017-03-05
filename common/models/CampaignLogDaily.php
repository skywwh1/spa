<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "campaign_log_daily".
 *
 * @property integer $campaign_id
 * @property integer $channel_id
 * @property integer $time
 * @property string $time_format
 * @property integer $clicks
 * @property integer $unique_clicks
 * @property integer $installs
 * @property integer $match_installs
 * @property string $pay_out
 * @property string $adv_price
 * @property string $daily_cap
 * @property Campaign $campaign
 * @property Channel $channel
 */
class CampaignLogDaily extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'campaign_log_daily';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign_id', 'channel_id', 'time'], 'required'],
            [['campaign_id', 'channel_id', 'time', 'clicks', 'unique_clicks', 'installs', 'match_installs'], 'integer'],
            [['pay_out', 'adv_price'], 'number'],
            [['time_format', 'daily_cap'], 'string', 'max' => 100],
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
            'time' => 'Time',
            'time_format' => 'Time Format',
            'clicks' => 'Clicks',
            'unique_clicks' => 'Unique Clicks',
            'installs' => 'Installs',
            'match_installs' => 'Match Installs',
            'pay_out' => 'Pay Out',
            'adv_price' => 'Adv Price',
            'daily_cap' => 'Daily Cap',
        ];
    }

    /**
     * @param $campaign_id
     * @param $channel_id
     * @param $time
     * @return CampaignLogDaily
     */
    public static function findIdentity($campaign_id, $channel_id, $time)
    {
        return static::findOne(['campaign_id' => $campaign_id, 'channel_id' => $channel_id, 'time' => $time]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaign()
    {
        return $this->hasOne(Campaign::className(), ['id' => 'campaign_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChannel()
    {
        return $this->hasOne(Channel::className(), ['id' => 'channel_id']);
    }
}
