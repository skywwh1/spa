<?php

namespace common\models;

use UrbanIndo\Yii2\DynamoDb\ActiveRecord;
use UrbanIndo\Yii2\DynamoDb\Query;

/**
 * This is the model class for table "log_click_dm".
 *
 * @property string $ip_campaign_channel_hour
 * @property integer $click_time
 */
class LogIp extends ActiveRecord
{

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return [
            'ip_campaign_channel_hour',
            'click_time',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_ip';
    }

    public static function primaryKey()
    {
        return ['ip_campaign_channel_hour'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['ip_campaign_channel_hour', 'click_time'], 'required'],
            [['ip_campaign_channel_hour', 'click_time',], 'safe'],
            [['ip_campaign_channel_hour'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ip_campaign_channel_hour' => 'Campaign Channel ID',
            'click_time' => 'Click Time',
        ];
    }

    /**
     * @param $id
     * @return LogIp|mixed
     */
    public static function findByPk($id)
    {
        $click = new LogIp();
        $query = new Query();
        $query->using = Query::USING_QUERY;
        $query->from('log_ip');
        $query->where(['ip_campaign_channel_hour' => $id]);
        $array = $query->one();
        if (!empty($array)) {
            $click = json_decode(json_encode($array), FALSE);
        }
        return $click;
    }
}
