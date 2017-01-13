<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "campaign_channel_log".
 *
 * @property integer $campaign_id
 * @property integer $channel_id
 * @property integer $pricing_mode
 * @property double $pay_out
 * @property integer $daily_cap
 * @property double $discount
 * @property integer $is_run
 * @property integer $creator
 * @property integer $create_time
 * @property integer $update_time
 * @property string $note
 *
 * @property Campaign $campaign
 * @property Channel $channel
 * @property User $creator0
 */
class Deliver extends \yii\db\ActiveRecord
{
    public $campaign_uuid;
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
            [['campaign_id', 'channel_id', 'pricing_mode', 'daily_cap', 'is_run', 'creator', 'create_time', 'update_time', 'step'], 'integer'],
            [['pay_out', 'discount'], 'number'],
            [['track_url', 'note'], 'string', 'max' => 255],
            [['campaign_id'], 'exist', 'skipOnError' => true, 'targetClass' => Campaign::className(), 'targetAttribute' => ['campaign_id' => 'id']],
            [['channel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Channel::className(), 'targetAttribute' => ['channel_id' => 'id']],
            [['creator'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator' => 'id']],
            ['channel0', 'ifExist'],
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
            'pricing_mode' => 'Pricing Mode',
            'pay_out' => 'Pay Out',
            'daily_cap' => 'Daily Cap',
            'discount' => 'Discount',
            'is_run' => 'Is Run',
            'creator' => 'Creator',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'note' => 'Note',
            'channel0' => 'Channel',
            'campaign_uuid' => 'Campaign UUID',
            'track_url' => 'Track Url',
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
//        echo $campaignId."<br>";
//        echo $channelId."<br>";
//        var_dump(static::findOne(['campaign_id' => $campaignId, 'channel_id' => $channelId]));
//        die();
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
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->create_time = time();
                $this->update_time = time();
                $this->creator = Yii::$app->user->identity->getId();
                $this->track_url = 'stream/track?' . 'pl=' . strtolower(\ModelsUtil::getPlatform($this->campaign->platform)) . "&ch_id=" . $this->channel_id . '&cp_uid=' . $this->campaign_uuid;
            } else {
                $this->update_time = time();
            }

            return true;

        } else {
            return false;
        }
    }

    public function setCampaignIdBy($uuid)
    {
        $this->campaign_id = Campaign::findOne(['campaign_uuid' => $uuid])->id;
    }

    public function setChannelIdBy($channel)
    {
        $this->channel_id = Channel::findOne(['username' => $channel])->id;
    }

}
