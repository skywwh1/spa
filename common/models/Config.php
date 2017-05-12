<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "config".
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 */
class Config extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'value' => 'Value',
        ];
    }


    public static function findLastStatsHourly()
    {
        $name = 'last_statics_hourly';
        $config = static::findOne(['name' => $name]);
        return isset($config) ? $config->value : 0;
    }

    public static function updateStatsTimeHourly($time)
    {
        $name = 'last_statics_hourly';

        $config = static::findOne(['name' => $name]);
        if ($config == null) {
            $config = new Config();
            $config->name = $name;
        }
        $config->value = $time;
        return $config->save();
    }


    public static function findLastStatsDaily()
    {
        $name = 'last_statics_daily';
        $config = static::findOne(['name' => $name]);
        return isset($config) ? $config->value : 0;
    }

    public static function updateStatsTimeDaily($time)
    {
        $name = 'last_statics_daily';
        $config = static::findOne(['name' => $name]);
        if ($config == null) {
            $config = new Config();
            $config->name = $name;
        }
        $config->value = $time;
        return $config->save();
    }

    public static function findLastCheckCvr()
    {
        $name = 'last_check_cvr';
        $config = static::findOne(['name' => $name]);
        return isset($config) ? $config->value : 0;
    }

    public static function updateLastCheckCvr($time)
    {
        $name = 'last_check_cvr';
        $config = static::findOne(['name' => $name]);
        if ($config == null) {
            $config = new Config();
            $config->name = $name;
        }
        $config->value = $time;
        return $config->save();
    }

    /**
     * @return int
     */
    public static function findLastStatsClickHourly()
    {
        $name = 'last_statics_clicks_hourly';
        $config = static::findOne(['name' => $name]);
        return isset($config) ? $config->value : time();
    }

    public static function updateLastStatsClickHourly($time)
    {
        $name = 'last_statics_clicks_hourly';
        $config = static::findOne(['name' => $name]);
        if ($config == null) {
            $config = new Config();
            $config->name = $name;
        }
        $config->value = $time;
        return $config->save();
    }
}
