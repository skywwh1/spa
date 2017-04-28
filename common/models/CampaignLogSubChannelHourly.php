<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "campaign_log_sub_channel_hourly".
 *
 * @property integer $campaign_id
 * @property integer $channel_id
 * @property string $sub_channel
 * @property integer $time
 * @property string $time_format
 * @property integer $clicks
 * @property integer $unique_clicks
 * @property integer $installs
 * @property integer $match_installs
 * @property integer $redirect_installs
 * @property integer $redirect_match_installs
 * @property string $pay_out
 * @property string $adv_price
 * @property string $daily_cap
 * @property string $cap
 * @property string $cost
 * @property string $redirect_cost
 * @property string $revenue
 * @property string $redirect_revenue
 * @property integer $create_time
 * @property Campaign $campaign
 * @property Channel $channel
 */
class CampaignLogSubChannelHourly extends \yii\db\ActiveRecord
{
    public $campaign_name;
    public $channel_name;
    public $om;
    public $cvr;
    public $match_cvr;
    public $def;
    public $deduction_percent;
    public $profit;
    public $margin;
    public $type;
    public $start;
    public $end;
    public $time_zone;
    public $timestamp;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'campaign_log_sub_channel_hourly';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign_id', 'channel_id', 'sub_channel', 'time'], 'required'],
            [['campaign_id', 'channel_id', 'time', 'clicks', 'unique_clicks', 'installs', 'match_installs', 'redirect_installs', 'redirect_match_installs', 'create_time'], 'integer'],
            [['pay_out', 'adv_price', 'cost', 'redirect_cost', 'revenue', 'redirect_revenue'], 'number'],
            [['sub_channel'], 'string', 'max' => 255],
            [['time_format', 'daily_cap', 'cap'], 'string', 'max' => 100],
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
            'time' => 'Time',
            'time_format' => 'Time Format',
            'clicks' => 'Clicks',
            'unique_clicks' => 'Unique Clicks',
            'installs' => 'Installs',
            'match_installs' => 'Match Installs',
            'redirect_installs' => 'Redirect Installs',
            'redirect_match_installs' => 'Redirect Match Installs',
            'pay_out' => 'Pay Out',
            'adv_price' => 'Adv Price',
            'daily_cap' => 'Daily Cap',
            'cap' => 'Cap',
            'cost' => 'Cost',
            'redirect_cost' => 'Redirect Cost',
            'revenue' => 'Revenue',
            'redirect_revenue' => 'Redirect Revenue',
            'create_time' => 'Create Time',
        ];
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

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->create_time = time();
        }
        return parent::beforeSave($insert);
    }
    /**
     * @param $campaign_id
     * @param $channel_id
     * @param $sub_channel_id
     * @param $timestamp
     * @return static
     */
    public static function findIdentity($campaign_id, $channel_id, $sub_channel_id, $timestamp)
    {
        return static::findOne(['campaign_id' => $campaign_id, 'channel_id' => $channel_id, 'sub_channel' => $sub_channel_id, 'time' => $timestamp]);
    }
}
