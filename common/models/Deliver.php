<?php

namespace common\models;

use common\utility\MailUtil;
use phpDocumentor\Reflection\Types\Integer;
use Yii;
use yii\db\Query;

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
 * @property integer $is_redirect
 * @property integer $is_run
 * @property integer $status
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
 * @property integer $is_manual
 * @property string $old_value
 * @property Campaign $campaign
 * @property Channel $channel
 * @property User $creator0
 */
class Deliver extends \yii\db\ActiveRecord
{
    public $channel0;
    public $step;
    public $newValue;
    public $oldValue;
    public $effect_time;
    public $time;
    public $campaign_name;
    public $target_geo;
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
            [['campaign_id', 'channel_id', 'pricing_mode', 'campaign_uuid', 'pay_out', 'discount', 'daily_cap'], 'required'],
            [['campaign_id', 'channel_id', 'discount_numerator', 'discount_denominator', 'is_redirect', 'is_run', 'status', 'end_time', 'creator', 'create_time', 'update_time', 'click', 'unique_click', 'install', 'match_install', 'def', 'step', 'is_send_create', 'is_manual'], 'integer'],
            [['adv_price', 'pay_out', 'actual_discount', 'cvr', 'cost', 'match_cvr', 'revenue', 'deduction_percent', 'profit', 'margin'], 'number'],
            ['discount', 'number', 'max' => 99, 'min' => 0],
            [['campaign_uuid', 'pricing_mode'], 'string', 'max' => 100],
            [['track_url'], 'string', 'max' => 255],
            [['channel0', 'daily_cap', 'note'], 'safe'],
            [['kpi', 'note', 'others'], 'string'],
            [['campaign_id'], 'exist', 'skipOnError' => true, 'targetClass' => Campaign::className(), 'targetAttribute' => ['campaign_id' => 'id']],
            [['channel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Channel::className(), 'targetAttribute' => ['channel_id' => 'id']],
            [['creator'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator' => 'id']],
            ['channel_id', 'unique', 'targetAttribute' => ['campaign_id', 'channel_id'], 'message' => isset($this->campaign) ? $this->campaign->campaign_uuid . ' already offer to ' . $this->channel->username : 'error!']
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
            'is_redirect' => 'Is Redirect',
            'is_run' => 'Is Run',
            'discount_numerator' => 'Discount Numerator',
            'discount_denominator' => 'Discount Denominator',
            'status' => 'Status',
            'creator' => 'Creator',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'end_time' => 'End Time',
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
            'kpi' => 'Kpi',
            'note' => 'Restriction',
            'others' => 'Others',
            'is_send_create' => 'If Notify',
            'is_manual' => 'Is Manual',
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
     * @param $campaignId
     * @param $channelId
     * @return Deliver
     */
    public static function findIdentity($campaignId, $channelId)
    {
        return static::findOne(['campaign_id' => $campaignId, 'channel_id' => $channelId]);
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
                'pl' => Campaign::findOne(['id' => $this->campaign_id])->platform,
                'ch_id' => $this->channel_id,
                'cp_uid' => $this->campaign_uuid,
            ];
            $this->track_url = Yii::$app->urlManager->createUrl($urlData);
        } else {
            $this->update_time = time();
        }
        return parent::beforeSave($insert);
    }

    public function setCampaignIdBy($uuid)
    {
        $camp = Campaign::findOne(['campaign_uuid' => $uuid]);
        if ($camp !== null) {
            $this->campaign_id = $camp->id;
        }
    }

    public function setChannelIdBy($channel)
    {
        $channel = Channel::findOne(['username' => $channel]);
        if ($channel !== null) {
            $this->channel_id = $channel->id;
        }
    }

    public static function findIdentityByCpUuidAndChid($campaignUuid, $channelId)
    {
        return static::findOne(['campaign_uuid' => $campaignUuid, 'channel_id' => $channelId]);
    }

    public static function getAllNeedSendCreate()
    {
        return static::find()->where(['is_send_create' => 0])->all();
    }

    /**
     * 查出需要停止的单子
     * @return array|Deliver[]
     */
    public static function getNeedPause()
    {
        return Deliver::find()
            ->where(['status' => 1])
            ->andWhere(['not', ['end_time' => null]])
            ->andWhere(['<', 'end_time', time()])
            ->all();
    }

    /**
     * @param Integer $campaignId
     * @return array|Deliver[]
     */
    public static function findRunningByCampaignId($campaignId)
    {
        return static::find()->where(['campaign_id' => $campaignId])->andWhere(['status' => 1])->all();
    }

    /**
     * API 自动更新。除手动停止那些单，is_manual =1.
     * @param $campaign_uuid
     * @param $status
     */
    public static function updateStsStatusByCampaignUid($campaign_uuid, $status)
    {
        static::updateAll(['status' => $status, 'end_time' => null], ['campaign_uuid' => $campaign_uuid, 'is_manual' => 0]);
    }

    /**
     * @param $campaign_id
     * @return array|Deliver[]
     */
    public static function findAllRunChannel($campaign_id)
    {
        return static::find()->where(['campaign_id' => $campaign_id])->all();
    }

}
