<?php

namespace frontend\models;

use common\models\Campaign;
use common\models\Channel;
use Yii;

/**
 * This is the model class for table "campaign_channel_log".
 *
 * @property integer $campaign_id
 * @property integer $channel_id
 * @property string $campaign_uuid
 * @property string $adv_price
 * @property string $pricing_mode
 * @property string $pay_out
 * @property string $daily_cap
 * @property string $actual_discount
 * @property string $discount
 * @property integer $discount_numerator
 * @property integer $discount_denominator
 * @property integer $status
 * @property integer $is_run
 * @property integer $end_time
 * @property integer $creator
 * @property integer $create_time
 * @property integer $update_time
 * @property string $track_url
 * @property integer $click
 * @property integer $unique_click
 * @property integer $install
 * @property string $cvr
 * @property string $cost
 * @property integer $match_install
 * @property string $match_cvr
 * @property string $revenue
 * @property integer $def
 * @property string $deduction_percent
 * @property string $profit
 * @property string $margin
 * @property string $kpi
 * @property string $note
 * @property string $others
 * @property integer $is_send_create
 *
 * @property Campaign $campaign
 * @property Channel $channel
 */
class CampaignChannelLog extends \yii\db\ActiveRecord
{
    public $creative_link;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'campaign_channel_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign_id', 'channel_id', 'creator'], 'required'],
            [['campaign_id', 'channel_id', 'discount_numerator', 'discount_denominator', 'status', 'is_run', 'end_time', 'creator', 'create_time', 'update_time', 'click', 'unique_click', 'install', 'match_install', 'def', 'is_send_create'], 'integer'],
            [['adv_price', 'pay_out', 'actual_discount', 'discount', 'cvr', 'cost', 'match_cvr', 'revenue', 'deduction_percent', 'profit', 'margin'], 'number'],
            [['kpi', 'note', 'others'], 'string'],
            [['creative_link'],'safe'],
            [['campaign_uuid', 'track_url'], 'string', 'max' => 255],
            [['pricing_mode', 'daily_cap'], 'string', 'max' => 100],
            [['campaign_id'], 'exist', 'skipOnError' => true, 'targetClass' => Campaign::className(), 'targetAttribute' => ['campaign_id' => 'id']],
            [['channel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Channel::className(), 'targetAttribute' => ['channel_id' => 'id']],
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
            'campaign_uuid' => 'Campaign Uuid',
            'adv_price' => 'Adv Price',
            'pricing_mode' => 'Pricing Mode',
            'pay_out' => 'Payout',
            'daily_cap' => 'Daily Cap',
            'actual_discount' => 'Actual Discount',
            'discount' => 'Discount',
            'discount_numerator' => 'Discount Numerator',
            'discount_denominator' => 'Discount Denominator',
            'status' => 'Status',
            'is_run' => 'Is Run',
            'end_time' => 'End Time',
            'creator' => 'Creator',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'track_url' => 'Track Url',
            'click' => 'Click',
            'unique_click' => 'Unique Click',
            'install' => 'Install',
            'cvr' => 'Cvr',
            'cost' => 'Cost',
            'match_install' => 'Match Install',
            'match_cvr' => 'Match Cvr',
            'revenue' => 'Revenue',
            'def' => 'Def',
            'deduction_percent' => 'Deduction Percent',
            'profit' => 'Profit',
            'margin' => 'Margin',
            'kpi' => 'KPI',
            'note' => 'Restriction',
            'others' => 'Others',
            'is_send_create' => 'Is Send Create',
            'creative_link' => 'Creative Link'
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

}
