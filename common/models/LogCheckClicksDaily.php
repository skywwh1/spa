<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "log_check_clicks_daily".
 *
 * @property integer $id
 * @property integer $campaign_id
 * @property integer $channel_id
 * @property integer $clicks
 * @property integer $match_install
 * @property string $match_cvr
 * @property integer $is_send
 * @property integer $time
 * @property integer $create_time
 *
 * @property Campaign $campaign
 * @property Channel $channel
 */
class LogCheckClicksDaily extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_check_clicks_daily';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign_id', 'channel_id', 'time'], 'required'],
            [['campaign_id', 'channel_id', 'clicks', 'match_install', 'is_send', 'time', 'create_time'], 'integer'],
            [['match_cvr'], 'string', 'max' => 255],
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
            'id' => 'ID',
            'campaign_id' => 'Campaign ID',
            'channel_id' => 'Channel ID',
            'clicks' => 'Clicks',
            'match_install' => 'Match Install',
            'match_cvr' => 'Match Cvr',
            'is_send' => 'Is Send',
            'time' => 'Time',
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
}
