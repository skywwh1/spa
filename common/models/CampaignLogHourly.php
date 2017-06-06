<?php

namespace common\models;

use DateInterval;
use DateTime;
use DateTimeZone;
use yii\db\Query;

/**
 * This is the model class for table "campaign_log_hourly".
 *
 * @property integer $campaign_id
 * @property integer $channel_id
 * @property integer $time
 * @property string $time_format
 * @property integer $clicks
 * @property integer $unique_clicks
 * @property integer $installs
 * @property integer $match_installs
 * @property integer $redirect_installs
 * @property integer $redirect_match_installs
 * @property string $pay_out
 * @property string $adv_price
 * @property string $daily_cap
 * @property string $cap
 * @property string $cost
 * @property string $redirect_cost
 * @property string $revenue
 * @property string $redirect_revenue
 * @property integer $create_time
 * @property Campaign $campaign
 * @property Channel $channel
 */
class CampaignLogHourly extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'campaign_log_hourly';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign_id', 'channel_id', 'time'], 'required'],
            [['campaign_id', 'channel_id', 'time', 'clicks', 'unique_clicks', 'installs', 'match_installs', 'redirect_installs', 'redirect_match_installs', 'create_time'], 'integer'],
            [['pay_out', 'adv_price', 'cost', 'redirect_cost', 'revenue', 'redirect_revenue'], 'number'],
            [['time_format', 'daily_cap', 'cap'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'campaign_id' => 'Campaign ID',
            'channel_id' => 'Channel ID',
            'time' => 'Time',
            'time_format' => 'Time Format',
            'clicks' => 'Clicks',
            'unique_clicks' => 'Unique Clicks',
            'installs' => 'Installs',
            'match_installs' => 'Match Installs',
            'redirect_post' => 'Redirect Installs',
            'redirect_match_installs' => 'Redirect Match Installs',
            'pay_out' => 'Pay Out',
            'adv_price' => 'Adv Price',
            'daily_cap' => 'Daily Cap',
            'cap' => 'Cap',
            'cost' => 'Cost',
            'redirect_cost' => 'Redirect Cost',
            'revenue' => 'Revenue',
            'redirect_revenue' => 'Redirect Revenue',
            'create_time' => 'Create Time',
        ];
    }

    /**
     * @param $campaign_id
     * @param $channel_id
     * @param $time
     * @return CampaignLogHourly
     */
    public static function findIdentity($campaign_id, $channel_id, $time)
    {
        return static::findOne(['campaign_id' => $campaign_id, 'channel_id' => $channel_id, 'time' => $time]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaign()
    {
        return $this->hasOne(Campaign::className(), ['id' => 'campaign_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChannel()
    {
        return $this->hasOne(Channel::className(), ['id' => 'channel_id']);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->create_time = time();
        }
        return parent::beforeSave($insert);
    }


    /**
     * @return array|CampaignLogHourly[]
     */
    public static function findNullPrice()
    {
        var_dump(static::find()->where('pay_out=0')->orWhere('adv_price=0')->createCommand()->sql);
        return static::find()->where('pay_out=0')->orWhere('adv_price=0')->all();
    }

    public static function findNullCap()
    {
        return static::find()->where(['cap' => null])->orWhere(['daily_cap' => null])->all();
    }

    /**
     * @param $start
     * @param $end
     * @param $campaign_id
     * @param $channel_id
     * @return array|null|CampaignLogHourly
     */
    public static function findDateReport($start, $end, $campaign_id, $channel_id)
    {
        $query = ReportChannelHourly::find();
        $query->alias('clh');
//        $a = strtotime($this->start);
        $query->select([
            'clh.campaign_id',
            'clh.channel_id',
            'clh.time timestamp',
            'clh.time_format',
            'clh.daily_cap',
            'SUM(clh.clicks) clicks',
            'SUM(clh.unique_clicks) unique_clicks',
            'SUM(clh.installs) installs',
            'SUM(clh.match_installs) match_installs',
            'SUM(clh.cost) cost',
            'SUM(clh.revenue) revenue',
            'AVG(clh.pay_out) pay_out',
            'AVG(clh.adv_price) adv_price',
        ]);

        // grid filtering conditions
        $query->andFilterWhere([
            'campaign_id' => $campaign_id,
            'channel_id' => $channel_id,

        ]);
        $query->groupBy([
            'clh.campaign_id',
            'clh.channel_id',
        ]);

        $query->andFilterWhere(['>=', 'time', $start])
            ->andFilterWhere(['<', 'time', $end]);
//        var_dump($start, $end, $campaign_id, $channel_id);
//        var_dump($query->createCommand()->sql);
//        die();
        return $query->one();
    }

    public static function getCurrentDay()
    {
        $query = new Query();
        $start = new DateTime(date('d-m-Y', time()), new DateTimeZone('Etc/GMT-8'));
        $end = new DateTime(date('d-m-Y', time()), new DateTimeZone('Etc/GMT-8'));
        $end = $end->add(new DateInterval('P1D'));
        $start = $start->getTimestamp();
        $end = $end->getTimestamp();
        $query->select([
            'ch.username channel_name',
            'cam.campaign_name campaign_name',
            'clh.campaign_id',
            'clh.channel_id',
            'UNIX_TIMESTAMP(FROM_UNIXTIME(clh.time, "%Y-%m-%d")) timestamp',
            'SUM(clh.clicks) clicks',
            'SUM(clh.unique_clicks) unique_clicks',
            'SUM(clh.installs) installs',
            'SUM(clh.match_installs) match_installs',
            'SUM(clh.redirect_installs) redirect_installs',
            'SUM(clh.redirect_match_installs) redirect_match_installs',
            'AVG(clh.pay_out) pay_out',
            'AVG(clh.adv_price) adv_price',
            'SUM(clh.cost) cost',
            'SUM(clh.revenue) revenue',
            'SUM(clh.redirect_cost) redirect_cost',
            'SUM(clh.redirect_revenue) redirect_revenue',
            'u.username om',
            'cam.daily_cap cap',
            'clh.daily_cap',

        ]);
        $query->from('campaign_log_hourly clh');
        $query->leftJoin('channel ch', 'clh.channel_id = ch.id');
        $query->leftJoin('campaign cam', 'clh.campaign_id = cam.id');
        $query->leftJoin('user u', 'ch.om = u.id');
        // grid filtering conditions

        $query->andFilterWhere(['<>', 'clh.daily_cap', 'open'])
            ->andFilterWhere(['<>', 'clh.daily_cap', '0'])
            ->andFilterWhere(['>=', 'time', $start])
            ->andFilterWhere(['<', 'time', $end]);

        $query->groupBy([
            'clh.campaign_id',
            'clh.channel_id',
            'timestamp',
        ]);
        $query->having('installs > daily_cap');
		var_dump($query->createCommand()->sql);        return $query->all();
    }
}
