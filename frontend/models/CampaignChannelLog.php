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
 * @property integer $pricing_mode
 * @property string $pay_out
 * @property integer $daily_cap
 * @property string $actual_discount
 * @property string $discount
 * @property integer $is_run
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
 * @property string $note
 *
 * @property Campaign $campaign
 * @property Channel $channel
 */
class CampaignChannelLog extends \yii\db\ActiveRecord
{
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
            [['campaign_id', 'channel_id', 'pricing_mode', 'creator'], 'required'],
            [['campaign_id', 'channel_id', 'pricing_mode', 'daily_cap', 'is_run', 'creator', 'create_time', 'update_time', 'click', 'unique_click', 'install', 'match_install', 'def'], 'integer'],
            [['adv_price', 'pay_out', 'actual_discount', 'discount', 'cvr', 'cost', 'match_cvr', 'revenue', 'deduction_percent', 'profit', 'margin'], 'number'],
            [['campaign_uuid'], 'string', 'max' => 100],
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
            'pay_out' => 'Pay Out',
            'daily_cap' => 'Daily Cap',
            'actual_discount' => 'Actual Discount',
            'discount' => 'Discount',
            'is_run' => 'Is Run',
            'create_time' => 'Create Time',
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
            'note' => 'Note',
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
