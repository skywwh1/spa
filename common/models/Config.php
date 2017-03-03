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
            [['value'], 'string'],
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


    public static function findLastStatsHourly($type)
    {
        $name = 'last_statics_click_hourly';
        switch ($type) {
            case 1:
                $name = 'last_statics_click_hourly';
                break;
            case 2:
                $name = 'last_statics_unique_click_hourly';
                break;
            case 3:
                $name = 'last_statics_post_hourly';
                break;
            case 4:
                $name = 'last_statics_feed_hourly';
                break;
        }
        $config = static::findOne(['name' => $name]);
        return isset($config) ? $config->value : 0;
    }

    public static function updateStatsTimeHourly($type, $time)
    {
        $name = 'last_statics_click_hourly';
        switch ($type) {
            case 1:
                $name = 'last_statics_click_hourly';
                break;
            case 2:
                $name = 'last_statics_unique_click_hourly';
                break;
            case 3:
                $name = 'last_statics_post_hourly';
                break;
            case 4:
                $name = 'last_statics_feed_hourly';
                break;
        }
        $config = static::findOne(['name' => $name]);
        if ($config == null) {
            $config = new Config();
            $config->name = $name;
        }
        $config->value = $time;
        return $config->save();
    }


    public static function findLastStatsDaily($type)
    {
        $name = 'last_statics_click_daily';
        switch ($type) {
            case 1:
                $name = 'last_statics_click_daily';
                break;
            case 2:
                $name = 'last_statics_unique_click_daily';
                break;
            case 3:
                $name = 'last_statics_post_daily';
                break;
            case 4:
                $name = 'last_statics_feed_daily';
                break;
        }
        $config = static::findOne(['name' => $name]);
        return isset($config) ? $config->value : 0;
    }

    public static function updateStatsTimeDaily($type, $time)
    {
        $name = 'last_statics_click_daily';
        switch ($type) {
            case 1:
                $name = 'last_statics_click_daily';
                break;
            case 2:
                $name = 'last_statics_unique_click_daily';
                break;
            case 3:
                $name = 'last_statics_post_daily';
                break;
            case 4:
                $name = 'last_statics_feed_daily';
                break;
        }
        $config = static::findOne(['name' => $name]);
        if ($config == null) {
            $config = new Config();
            $config->name = $name;
        }
        $config->value = $time;
        return $config->save();
    }
}
