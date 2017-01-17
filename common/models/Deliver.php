<?php

namespace common\models;

use common\utility\MailUtil;
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
 * @property User $creator0
 */
class Deliver extends \yii\db\ActiveRecord
{
    public $channel0;
    public $step;

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
            [['campaign_id', 'channel_id', 'pricing_mode', 'campaign_uuid', 'channel0', 'pay_out', 'discount', 'daily_cap'], 'required'],
            [['campaign_id', 'channel_id', 'pricing_mode', 'daily_cap', 'is_run', 'creator', 'create_time', 'update_time', 'click', 'unique_click', 'install', 'match_install', 'def', 'step'], 'integer'],
            [['adv_price', 'pay_out', 'actual_discount', 'discount', 'cvr', 'cost', 'match_cvr', 'revenue', 'deduction_percent', 'profit', 'margin'], 'number'],
            [['campaign_uuid'], 'string', 'max' => 100],
            [['track_url', 'note'], 'string', 'max' => 255],
            [['campaign_id'], 'exist', 'skipOnError' => true, 'targetClass' => Campaign::className(), 'targetAttribute' => ['campaign_id' => 'id']],
            [['channel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Channel::className(), 'targetAttribute' => ['channel_id' => 'id']],
            [['creator'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator' => 'id']],
//            ['channel0', 'ifExist'],
            ['channel_id', 'unique', 'targetAttribute' => ['campaign_id', 'channel_id'], 'message' => 'The Campaign had been offer to this channel']
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
            'campaign_uuid' => 'Campaign UUID',
            'adv_price' => 'Adv Price',
            'pricing_mode' => 'Pricing Mode',
            'pay_out' => 'Pay Out',
            'daily_cap' => 'Daily Cap',
            'actual_discount' => 'Actual Discount',
            'discount' => 'Discount',
            'is_run' => 'Is Run',
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
            'note' => 'Note',
            'channel0' => 'Channel',
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

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator0()
    {
        return $this->hasOne(User::className(), ['id' => 'creator']);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($campaignId, $channelId)
    {
        return static::findOne(['campaign_id' => $campaignId, 'channel_id' => $channelId]);
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if ($insert) {
            MailUtil::sendSTSCreateMail($this);
        }
    }

    public function ifExist()
    {
        if (static::findIdentity($this->campaign_id, $this->channel_id)) {
            $this->addError('channel0', 'The Campaign had been offer to this channel');
        }
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->create_time = time();
            $this->update_time = time();
            $this->creator = Yii::$app->user->identity->getId();
            $urlData = ['stream/track',
                'pl' => strtolower(\ModelsUtil::getPlatform($this->campaign->platform)),
                'ch_id' => $this->channel_id,
                'cp_uid' => $this->campaign_uuid];
            $this->track_url = Yii::$app->urlManager->createUrl($urlData);
        } else {
            $this->update_time = time();
        }
        return parent::beforeSave($insert);
    }

    public function setCampaignIdBy($uuid)
    {
        $this->campaign_id = Campaign::findOne(['campaign_uuid' => $uuid])->id;
    }

    public function setChannelIdBy($channel)
    {
        $this->channel_id = Channel::findOne(['username' => $channel])->id;
    }

    public static function findIdentityByCpUuidAndChid($campaignUuid, $channelId)
    {
        return static::findOne(['campaign_uuid' => $campaignUuid, 'channel_id' => $channelId]);
    }
}
