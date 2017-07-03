<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "channel_sub_whitelist".
 *
 * @property integer $id
 * @property integer $channel_id
 * @property string $sub_channel
 * @property string $geo
 * @property string $os
 * @property string $category
 * @property string $note
 * @property integer $create_time
 *
 * @property Channel $channel
 */
class ChannelSubWhitelist extends \yii\db\ActiveRecord
{
    public $channel_name;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'channel_sub_whitelist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channel_id'], 'required'],
            [['channel_id', 'create_time'], 'integer'],
            [['note'], 'string'],
            [['sub_channel', 'geo', 'os', 'category'], 'safe'],
            [['channel_id', 'sub_channel'], 'unique', 'targetAttribute' => ['channel_id', 'sub_channel'], 'message' => 'The combination of Channel ID and Sub Channel has already been taken.'],
            [['channel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Channel::className(), 'targetAttribute' => ['channel_id' => 'id']],
            ['channel_name', 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'channel_id' => 'Channel ID',
            'sub_channel' => 'Sub Channel',
            'geo' => 'Geo',
            'os' => 'Os',
            'category' => 'Category',
            'note' => 'Note',
            'create_time' => 'Create Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChannel()
    {
        return $this->hasOne(Channel::className(), ['id' => 'channel_id']);
    }
}
