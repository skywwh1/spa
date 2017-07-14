<?php

namespace common\models;

use UrbanIndo\Yii2\DynamoDb\ActiveRecord;
use UrbanIndo\Yii2\DynamoDb\Query;

/**
 * This is the model class for table "log_click_dm".
 *
 * @property string $click_uuid
 * @property string $click_id
 * @property string $campaign_channel_id
 * @property string $ch_subid
 * @property string $gaid
 * @property string $idfa
 * @property string $adv_price
 * @property string $pay_out
 * @property string $all_parameters
 * @property integer $ip_long
 * @property integer $redirect_campaign_id
 * @property integer $click_time
 */
class LogClickDM extends ActiveRecord
{
    protected $_findType = Query::USING_QUERY;

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return ['click_uuid',
            'click_id',
            'campaign_channel_id',
            'ch_subid',
            'gaid',
            'idfa',
            'adv_price',
            'pay_out',
            'all_parameters',
            'ip_long',
            'redirect_campaign_id',
            'click_time',
        ];
    }

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_click_dm';
    }

    public static function primaryKey()
    {
        return ['click_uuid'];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['click_uuid', 'campaign_channel_id'], 'required'],
            [['ip_long', 'click_time',], 'safe'],
            [['adv_price', 'pay_out', 'redirect_campaign_id'], 'safe'],
            [['click_uuid', 'click_id', 'ch_subid', 'gaid', 'idfa', 'all_parameters',], 'safe'],
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
            'click_uuid' => 'Click Uuid',
            'click_id' => 'Click ID',
            'campaign_channel_id' => 'Campaign Channel ID',
            'ch_subid' => 'Ch Subid',
            'gaid' => 'Gaid',
            'idfa' => 'Idfa',
            'adv_price' => 'Adv Price',
            'pay_out' => 'Pay Out',
            'all_parameters' => 'All Parameters',
            'ip_long' => 'Ip Long',
            'redirect_campaign_id' => 'Redirect Campaign ID',
            'click_time' => 'Click Time',
        ];
    }

    /**
     * @param $id
     * @return LogClickDM|mixed
     */
    public static function findById($id)
    {
        $click = new LogClickDM();
        $query = new Query();
        $query->using = Query::USING_QUERY;
        $query->from('log_click_dm');
        $query->where(['click_uuid' => $id]);
        $array = $query->one();
        if (!empty($array)) {
            $click = json_decode(json_encode($array), FALSE);
        }
        return $click;
    }

    /**
     * @param $campaign_channel_id
     * @param $ip
     * @return bool
     */
    public static function isExistIp($campaign_channel_id, $ip)
    {
        $query = new Query();
        $query->using = Query::USING_SCAN;
        $query->from('log_click_dm');
        $query->where(['campaign_channel_id' => $campaign_channel_id]);
        $query->andWhere(['ip_long' => $ip]);
        $query->andWhere(['>', 'click_time', time() - 3600]);
        $array = $query->all();
        if (!empty($array)) {
            return true;
        }
        return false;
    }
}
