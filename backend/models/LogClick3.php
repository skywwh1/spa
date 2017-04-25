<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "log_click_3".
 *
 * @property string $click_uuid
 * @property integer $tx_id
 * @property string $click_id
 * @property integer $channel_id
 * @property integer $campaign_id
 * @property string $campaign_uuid
 * @property string $pl
 * @property string $ch_subid
 * @property string $gaid
 * @property string $idfa
 * @property string $site
 * @property string $adv_price
 * @property string $pay_out
 * @property string $discount
 * @property string $daily_cap
 * @property string $all_parameters
 * @property string $ip
 * @property integer $ip_long
 * @property string $redirect
 * @property integer $redirect_campaign_id
 * @property string $redirect_to
 * @property string $browser
 * @property string $browser_type
 * @property integer $click_time
 * @property integer $create_time
 */
class LogClick3 extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_click_3';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['click_uuid'], 'required'],
            [['tx_id', 'channel_id', 'campaign_id', 'ip_long', 'redirect_campaign_id', 'click_time', 'create_time'], 'integer'],
            [['adv_price', 'pay_out', 'discount'], 'number'],
            [['click_uuid', 'click_id', 'campaign_uuid', 'pl', 'ch_subid', 'gaid', 'idfa', 'site', 'all_parameters', 'ip', 'redirect', 'redirect_to', 'browser', 'browser_type'], 'string', 'max' => 255],
            [['daily_cap'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'click_uuid' => 'Click Uuid',
            'tx_id' => 'Tx ID',
            'click_id' => 'Click ID',
            'channel_id' => 'Channel ID',
            'campaign_id' => 'Campaign ID',
            'campaign_uuid' => 'Campaign Uuid',
            'pl' => 'Pl',
            'ch_subid' => 'Ch Subid',
            'gaid' => 'Gaid',
            'idfa' => 'Idfa',
            'site' => 'Site',
            'adv_price' => 'Adv Price',
            'pay_out' => 'Pay Out',
            'discount' => 'Discount',
            'daily_cap' => 'Daily Cap',
            'all_parameters' => 'All Parameters',
            'ip' => 'Ip',
            'ip_long' => 'Ip Long',
            'redirect' => 'Redirect',
            'redirect_campaign_id' => 'Redirect Campaign ID',
            'redirect_to' => 'Redirect To',
            'browser' => 'Browser',
            'browser_type' => 'Browser Type',
            'click_time' => 'Click Time',
            'create_time' => 'Create Time',
        ];
    }
}
