<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "log_post_hourly".
 *
 * @property integer $channel_id
 * @property integer $time
 * @property string $cost
 * @property string $revenue
 * @property string $pay_out
 * @property integer $create_time
 */
class LogPostHourly extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_post_hourly';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channel_id', 'time'], 'required'],
            [['channel_id', 'time', 'create_time'], 'integer'],
            [['cost', 'revenue', 'pay_out'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'channel_id' => 'Channel ID',
            'time' => 'Time',
            'cost' => 'Cost',
            'revenue' => 'Revenue',
            'pay_out' => 'Pay Out',
            'create_time' => 'Create Time',
        ];
    }
}
