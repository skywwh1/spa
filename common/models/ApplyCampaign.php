<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "apply_campaign".
 *
 * @property integer $campaign_id
 * @property integer $channel_id
 * @property integer $status
 * @property integer $create_time
 *
 * @property Campaign $campaign
 * @property Channel $channel
 */
class ApplyCampaign extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'apply_campaign';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign_id', 'channel_id'], 'required'],
            [['campaign_id', 'channel_id', 'status', 'create_time'], 'safe'],
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
            'status' => 'Status',
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

    /**
     * @param $campaign_id
     * @param $channel_id
     * @return static
     */
    public static function findIdentify($campaign_id, $channel_id)
    {
        return static::findOne(['campaign_id' => $campaign_id, 'channel_id' => $channel_id]);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->create_time = time();
            return true;
        }
        return false;
    }


}
