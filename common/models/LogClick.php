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
 * @property string $adv_price
 * @property string $pay_out
 * @property string $discount
 * @property string $daily_cap
 * @property string $all_parameters
 * @property string $ip
 * @property integer $ip_long
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
            [['click_uuid', 'channel_id', 'campaign_id', 'campaign_uuid'], 'required'],
            [['tx_id', 'channel_id', 'campaign_id', 'ip_long', 'click_time', 'create_time'], 'safe'],
            [['adv_price', 'pay_out', 'discount'], 'safe'],
            [['click_uuid', 'click_id', 'campaign_uuid', 'daily_cap', 'pl', 'ch_subid', 'gaid', 'idfa', 'site', 'all_parameters', 'ip', 'redirect', 'browser', 'browser_type'], 'safe'],
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
            'adv_price' => 'Adv Price',
            'pay_out' => 'Pay Out',
            'discount' => 'Discount',
            'daily_cap' => 'Daily Cap',
            'all_parameters' => 'All Parameters',
            'ip' => 'Ip',
            'ip_long' => 'Ip Long',
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

    /**
     * @param $campaign_id
     * @param $channel_id
     * @return int|string
     */
    public static function findUniqueClicks($campaign_id, $channel_id)
    {
        $query = static::find();
        $query->select('ip');
        $query->distinct();
        $query->where(['campaign_id' => $campaign_id]);
        $query->andWhere(['channel_id' => $channel_id]);
        return $query->count();
    }

    /**
     * @param $campaign_id
     * @param $channel_id
     * @param $ip
     * @return bool
     */
    public static function findClickIpExist($campaign_id, $channel_id, $ip)
    {
        $query = static::find();
        $query->select('id');
        $query->where(['campaign_id' => $campaign_id]);
        $query->andWhere(['channel_id' => $channel_id]);
        $query->andWhere(['ip' => $ip]);
        $result = $query->count();
        if ($result > 1) {
            return true;
        }
        return false;
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->create_time = time();
        }
        return parent::beforeSave($insert);
    }
}
