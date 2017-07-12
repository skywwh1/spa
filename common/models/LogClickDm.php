<?php

namespace common\models;

use UrbanIndo\Yii2\DynamoDb\ActiveRecord;

/**
 * This is the model class for table "log_click".
 *
 * @property string $click_uuid
 * @property string $click_id
 * @property integer $channel_id
 * @property integer $campaign_id
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

    /**
     * @inheritdoc
     */
    public function attributes()
    {
        return ['click_uuid',
            'click_id',
            'channel_id',
            'campaign_id',
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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['click_uuid', 'channel_id', 'campaign_id'], 'required'],
            [['channel_id', 'campaign_id', 'ip_long', 'click_time',], 'safe'],
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
            'channel_id' => 'Channel ID',
            'campaign_id' => 'Campaign ID',
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

}
