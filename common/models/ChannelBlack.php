<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "channel_black".
 *
 * @property integer $id
 * @property integer $advertiser
 * @property integer $channel_id
// * @property integer $campaign_id
 * @property string $geo
 * @property string $os
 * @property integer $action_type
 * @property string $note
 *
 * @property Advertiser $advertiser0
 * @property Campaign $campaign
 * @property Channel $channel
 */
class ChannelBlack extends \yii\db\ActiveRecord
{
    public $channel_name;
//    public $campaign_name;
//    public $campaign_uuid;
    public $advertiser_name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channel_black';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['advertiser', 'channel_id',], 'required'],
            [[ 'channel_id',], 'integer'],
            [['note'], 'string'],
            [['channel_name','campaign_name','advertiser','action_type','geo','os','advertiser_name'], 'safe'],
            [['advertiser'], 'exist', 'skipOnError' => true, 'targetClass' => Advertiser::className(), 'targetAttribute' => ['advertiser' => 'id']],
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
            'advertiser' => 'Advertiser',
            'channel_id' => 'Channel ID',
            'geo' => 'Geo',
            'os' => 'OS',
            'action_type' => 'Action Type',
            'note' => 'Note',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertiser0()
    {
        return $this->hasOne(Advertiser::className(), ['id' => 'advertiser']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChannel()
    {
        return $this->hasOne(Channel::className(), ['id' => 'channel_id']);
    }
}
