<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "log_click".
 *
 * @property integer $id
 * @property integer $tx_id
 * @property string $click_uuid
 * @property string $click_id
 * @property integer $channel_id
 * @property integer $campaign_id
 * @property string $campaign_uuid
 * @property string $pl
 * @property string $ch_subid
 * @property string $gaid
 * @property string $idfa
 * @property string $site
 * @property string $pay_out
 * @property string $discount
 * @property integer $daily_cap
 * @property string $all_parameters
 * @property string $ip
 * @property string $redirect
 * @property string $browser
 * @property string $browser_type
 * @property integer $click_time
 * @property integer $create_time
 */
class LogClick extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_click';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tx_id', 'click_uuid', 'channel_id', 'campaign_id', 'campaign_uuid'], 'required'],
            [['tx_id', 'channel_id', 'campaign_id', 'daily_cap', 'click_time', 'create_time'], 'integer'],
            [['pay_out', 'discount'], 'number'],
            [['click_uuid', 'click_id', 'campaign_uuid', 'pl', 'ch_subid', 'gaid', 'idfa', 'site', 'all_parameters', 'ip', 'redirect', 'browser', 'browser_type'], 'string', 'max' => 255],
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
            'tx_id' => 'Tx ID',
            'click_uuid' => 'Click Uuid',
            'click_id' => 'Click ID',
            'channel_id' => 'Channel ID',
            'campaign_id' => 'Campaign ID',
            'campaign_uuid' => 'Campaign Uuid',
            'pl' => 'Pl',
            'ch_subid' => 'Ch Subid',
            'gaid' => 'Gaid',
            'idfa' => 'Idfa',
            'site' => 'Site',
            'pay_out' => 'Pay Out',
            'discount' => 'Discount',
            'daily_cap' => 'Daily Cap',
            'all_parameters' => 'All Parameters',
            'ip' => 'Ip',
            'redirect' => 'Redirect',
            'browser' => 'Browser',
            'browser_type' => 'Browser Type',
            'click_time' => 'Click Time',
            'create_time' => 'Create Time',
        ];
    }

    /**
     * @param $uuid
     * @return LogClick
     */
    public static function findByClickUuid($uuid)
    {
        return static::findOne(['click_uuid' => $uuid]);
    }
}
