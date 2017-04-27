<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "log_event".
 *
 * @property integer $id
 * @property string $click_uuid
 * @property string $auth_token
 * @property integer $channel_id
 * @property string $event_name
 * @property string $event_value
 * @property integer $create_time
 * @property integer $update_time
 * @property string $ip
 * @property integer $ip_long
 */
class LogEvent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_event';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['click_uuid', 'auth_token', 'channel_id', 'event_name'], 'required'],
            [['channel_id', 'create_time', 'update_time', 'ip_long'], 'integer'],
            [['click_uuid', 'auth_token', 'event_name', 'event_value', 'ip'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'click_uuid' => 'Click Uuid',
            'auth_token' => 'Auth Token',
            'channel_id' => 'Channel ID',
            'event_name' => 'Event Name',
            'event_value' => 'Event Value',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'ip' => 'Ip',
            'ip_long' => 'Ip Long',
        ];
    }
}
