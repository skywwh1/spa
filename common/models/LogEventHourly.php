<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "log_event_hourly".
 *
 * @property integer $id
 * @property integer $campaign_id
 * @property integer $channel_id
 * @property string $ch_subid
 * @property integer $time
 * @property string $event
 * @property integer $match_total
 * @property integer $total
 * @property integer $create_time
 */
class LogEventHourly extends \yii\db\ActiveRecord
{
    public $timestamp;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_event_hourly';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign_id', 'channel_id', 'time', 'match_total', 'total', 'create_time'], 'integer'],
            [['event'], 'string', 'max' => 11],
            [['campaign_id', 'channel_id', 'time', 'event','ch_subid'], 'unique', 'targetAttribute' => ['campaign_id', 'channel_id', 'time', 'event'], 'message' => 'The combination of Campaign ID, Channel ID, Time and Event has already been taken.'],
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
            'time' => 'Time',
            'event' => 'Event',
            'match_total' => 'Match Total',
            'total' => 'Total',
            'create_time' => 'Create Time',
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
