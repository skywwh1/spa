<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "log_feed_hourly".
 *
 * @property integer $adv_id
 * @property integer $campaign_id
 * @property integer $time
 * @property string $time_format
 * @property string $adv_price
 * @property string $revenue
 * @property string $cost
 * @property integer $create_time
 */
class LogFeedHourly extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_feed_hourly';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['adv_id', 'campaign_id', 'time'], 'required'],
            [['adv_id', 'campaign_id', 'time', 'create_time'], 'integer'],
            [['adv_price', 'revenue', 'cost'], 'number'],
            [['time_format'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'adv_id' => 'Adv ID',
            'campaign_id' => 'Campaign ID',
            'time' => 'Time',
            'time_format' => 'Time Format',
            'adv_price' => 'Adv Price',
            'revenue' => 'Revenue',
            'cost' => 'Cost',
            'create_time' => 'Create Time',
        ];
    }
}
