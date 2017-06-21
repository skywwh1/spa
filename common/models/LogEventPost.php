<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "log_event_post".
 *
 * @property integer $id
 * @property string $click_uuid
 * @property string $click_id
 * @property integer $campaign_id
 * @property integer $channel_id
 * @property string $event_name
 * @property string $event_value
 * @property string $idfa
 * @property string $gaid
 * @property string $user_ip
 * @property string $geo
 * @property string $lang
 * @property string $post_link
 * @property integer $post_time
 * @property integer $create_time
 * @property string $ip
 * @property integer $ip_long
 */
class LogEventPost extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_event_post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['click_uuid', 'click_id', 'campaign_id', 'channel_id', 'event_name'], 'required'],
            [['campaign_id', 'channel_id', 'post_time', 'create_time', 'ip_long'], 'integer'],
            [['post_link'], 'string'],
            [['click_uuid', 'click_id', 'event_name', 'event_value', 'idfa', 'gaid', 'user_ip', 'geo', 'lang', 'ip'], 'string', 'max' => 255],
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
            'click_id' => 'Click ID',
            'campaign_id' => 'Campaign ID',
            'channel_id' => 'Channel ID',
            'event_name' => 'Event Name',
            'event_value' => 'Event Value',
            'idfa' => 'Idfa',
            'gaid' => 'Gaid',
            'user_ip' => 'User Ip',
            'geo' => 'Geo',
            'lang' => 'Lang',
            'post_link' => 'Post Link',
            'post_time' => 'Post Time',
            'create_time' => 'Create Time',
            'ip' => 'Ip',
            'ip_long' => 'Ip Long',
        ];
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->create_time = time();
        }
        return parent::beforeSave($insert);
    }
}
