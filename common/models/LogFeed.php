<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "log_feed".
 *
 * @property integer $id
 * @property string $auth_token
 * @property string $click_uuid
 * @property string $click_id
 * @property integer $channel_id
 * @property integer $campaign_id
 * @property string $ch_subid
 * @property string $all_parameters
 * @property string $ip
 * @property integer $feed_time
 * @property integer $create_time
 */
class LogFeed extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_feed';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['click_uuid', 'channel_id', 'campaign_id'], 'required'],
            [['channel_id', 'campaign_id', 'feed_time', 'create_time'], 'integer'],
            [['all_parameters'], 'string'],
            [['auth_token'], 'string', 'max' => 32],
            [['click_uuid', 'click_id', 'ch_subid', 'ip'], 'string', 'max' => 255],
            [['click_uuid'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'auth_token' => 'Auth Token',
            'click_uuid' => 'Click Uuid',
            'click_id' => 'Click ID',
            'channel_id' => 'Channel ID',
            'campaign_id' => 'Campaign ID',
            'ch_subid' => 'Ch Subid',
            'all_parameters' => 'All Parameters',
            'ip' => 'Ip',
            'feed_time' => 'Feed Time',
            'create_time' => 'Create Time',
        ];
    }
}
