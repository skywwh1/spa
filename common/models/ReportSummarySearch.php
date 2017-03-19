<?php

namespace common\models;

use DateInterval;
use DateTime;
use DateTimeZone;
use yii\data\ActiveDataProvider;
use yii\db\Query;


class ReportSummarySearch extends ReportSummaryHourly
{
    public $time_zone;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign_id', 'channel_id', 'time', 'clicks', 'unique_clicks', 'installs', 'match_installs',
                'campaign_name', 'channel_name', 'adv_name'], 'safe'],
            [['time_zone', 'time_format', 'daily_cap', 'type', 'start', 'end', 'adv_name', 'bd', 'om',
                'category', 'geo', 'price_model', 'platform', 'device', 'traffic_source', 'subid', 'pm', 'campaign_uuid'], 'safe'],
            [['pay_out', 'adv_price'], 'number'],
        ];
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function hourlySearch($params)
    {

        $query = ReportSummaryHourly::find();
        $query->alias('clh');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $start = new DateTime($this->start, new DateTimeZone($this->time_zone));
        $end = new DateTime($this->end, new DateTimeZone($this->time_zone));
        $end = $end->add(new DateInterval('P1D'));
        $start = $start->getTimestamp();
        $end = $end->getTimestamp();
        $query->select([
            'ch.username channel_name',
            'cam.campaign_name campaign_name',
            'cam.campaign_uuid campaign_uuid',
            'cam.category category',
            'cam.pricing_mode price_model',
            'cam.platform platform',
            'cam.device device',
            'cam.traffic_source traffic_source',

            'clh.campaign_id',
            'clh.channel_id',
            'clh.time timestamp',
            'clh.time_format',
            'clh.clicks',
            'clh.unique_clicks',
            'clh.installs',
            'clh.match_installs',
            'clh.pay_out',
            'clh.adv_price',
            'clh.daily_cap',
            'ad.username adv_name',
            'u.username bd',
            'o.username om',

        ]);
        $query->joinWith('channel ch');
        $query->joinWith('campaign cam');
        $query->leftJoin('advertiser ad', 'cam.advertiser = ad.id');
        $query->leftJoin('user u', 'ad.bd = u.id');
        $query->leftJoin('user o', 'ch.om = o.id');

        // grid filtering conditions
        $query->andFilterWhere([
            'campaign_id' => $this->campaign_id,
            'channel_id' => $this->channel_id,
            'pay_out' => $this->pay_out,
            'adv_price' => $this->adv_price,
            'ch.username' => $this->channel_name,
            'ad.username' => $this->adv_name,
            'u.username' => $this->bd,
            'o.username' => $this->om,
            'cam.campaign_uuid' => $this->campaign_uuid,
            'cam.category' => $this->category,
            'cam.pricing_mode' => $this->price_model,
            'cam.platform' => $this->platform,
            'cam.device' => $this->device,
            'cam.traffic_source' => $this->traffic_source,
        ]);

        $query->andFilterWhere(['like', 'time_format', $this->time_format])
            ->andFilterWhere(['like', 'ch.username', $this->channel_name])
            ->andFilterWhere(['like', 'cam.campaign_name', $this->campaign_name])
            ->andFilterWhere(['like', 'cam.target_geo', $this->geo])
            ->andFilterWhere(['like', 'u.username', $this->bd])
            ->andFilterWhere(['like', 'o.username', $this->om])
            ->andFilterWhere(['>=', 'time', $start])
            ->andFilterWhere(['<', 'time', $end]);
        $query->orderBy(['ad.username' => SORT_ASC, 'cam.campaign_name' => SORT_ASC, 'ch.username' => SORT_ASC, 'time' => SORT_DESC]);
//        var_dump($start);
//        var_dump($end);
//        var_dump($query->createCommand()->sql);
//        die();
        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function dailySearch($params)
    {

//        $query = ReportSummaryDaily::find();
        $query = new Query();
//        $query->alias('clh');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $start = new DateTime($this->start, new DateTimeZone($this->time_zone));
        $end = new DateTime($this->end, new DateTimeZone($this->time_zone));
//        $start = $start->sub(new DateInterval('P1D'));
        $end = $end->add(new DateInterval('P1D'));
        $start = $start->getTimestamp();
        $end = $end->getTimestamp();
        $query->select([
            'ch.username channel_name',
            'cam.campaign_name campaign_name',
            'cam.campaign_uuid campaign_uuid',
            'cam.category category',
            'cam.pricing_mode price_model',
            'cam.platform platform',
            'cam.device device',
            'cam.traffic_source traffic_source',

            'clh.campaign_id',
            'clh.channel_id',
//            'FROM_UNIXTIME(clh.time,"%Y-%m-%d") time',
            'UNIX_TIMESTAMP(FROM_UNIXTIME(clh.time, "%Y-%m-%d")) timestamp',
            'SUM(clh.clicks) clicks',
            'SUM(clh.unique_clicks) unique_clicks',
            'SUM(clh.installs) installs',
            'SUM(clh.match_installs) match_installs',
            'AVG(clh.pay_out) pay_out',
            'AVG(clh.adv_price) adv_price',
            'ad.username adv_name',
            'u.username bd',
            'o.username om',

        ]);
        $query->from('campaign_log_hourly clh');
        $query->leftJoin('channel ch', 'clh.channel_id = ch.id');
        $query->leftJoin('campaign cam', 'clh.campaign_id = cam.id');
        $query->leftJoin('advertiser ad', 'cam.advertiser = ad.id');
        $query->leftJoin('user u', 'ad.bd = u.id');
        $query->leftJoin('user o', 'ch.om = o.id');

        // grid filtering conditions
        $query->andFilterWhere([
            'campaign_id' => $this->campaign_id,
            'channel_id' => $this->channel_id,
            'pay_out' => $this->pay_out,
            'adv_price' => $this->adv_price,
            'ch.username' => $this->channel_name,
            'ad.username' => $this->adv_name,
            'u.username' => $this->bd,
            'o.username' => $this->om,
            'cam.campaign_uuid' => $this->campaign_uuid,
            'cam.category' => $this->category,
            'cam.pricing_mode' => $this->price_model,
            'cam.platform' => $this->platform,
            'cam.device' => $this->device,
            'cam.traffic_source' => $this->traffic_source,
        ]);

        $query->andFilterWhere(['like', 'ch.username', $this->channel_name])
            ->andFilterWhere(['like', 'cam.campaign_name', $this->campaign_name])
            ->andFilterWhere(['like', 'cam.target_geo', $this->geo])
            ->andFilterWhere(['like', 'u.username', $this->bd])
            ->andFilterWhere(['like', 'o.username', $this->om])
            ->andFilterWhere(['>=', 'time', $start])
            ->andFilterWhere(['<', 'time', $end]);
        $query->groupBy([
            'clh.campaign_id',
            'clh.channel_id',
            'timestamp',
        ]);
        $query->orderBy(['ch.username' => SORT_ASC, 'cam.campaign_name' => SORT_ASC, 'time' => SORT_DESC]);
        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function summarySearch($params)
    {

        $query = ReportSummaryHourly::find();
        $query->alias('clh');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        $start = new DateTime($this->start, new DateTimeZone($this->time_zone));
        $end = new DateTime($this->end, new DateTimeZone($this->time_zone));
        $end = $end->add(new DateInterval('P1D'));
        $start = $start->getTimestamp();
        $end = $end->getTimestamp();
        $query->select([
            'ch.username channel_name',
            'cam.campaign_name campaign_name',
            'cam.campaign_uuid campaign_uuid',
            'cam.category category',
            'cam.pricing_mode price_model',
            'cam.platform platform',
            'cam.device device',
            'cam.traffic_source traffic_source',

            'clh.campaign_id',
            'clh.channel_id',
            'clh.time',
            'clh.time_format',
            'sum(clh.clicks) clicks',
            'sum(clh.unique_clicks) unique_clicks',
            'sum(clh.installs) installs',
            'sum(clh.match_installs) match_installs',
            'avg(clh.pay_out) pay_out',
            'avg(clh.adv_price) adv_price',
            'clh.daily_cap',
            'ad.username adv_name',
            'u.username bd',
            'o.username om',

        ]);
        $query->joinWith('channel ch');
        $query->joinWith('campaign cam');
        $query->leftJoin('advertiser ad', 'cam.advertiser = ad.id');
        $query->leftJoin('user u', 'ad.bd = u.id');
        $query->leftJoin('user o', 'ch.om = o.id');

        // grid filtering conditions
        $query->andFilterWhere([
            'campaign_id' => $this->campaign_id,
            'channel_id' => $this->channel_id,
            'pay_out' => $this->pay_out,
            'adv_price' => $this->adv_price,
            'ch.username' => $this->channel_name,
            'ad.username' => $this->adv_name,
            'u.username' => $this->bd,
            'o.username' => $this->om,
            'cam.campaign_uuid' => $this->campaign_uuid,
            'cam.category' => $this->category,
            'cam.pricing_mode' => $this->price_model,
            'cam.platform' => $this->platform,
            'cam.device' => $this->device,
            'cam.traffic_source' => $this->traffic_source,
        ]);

        $query->andFilterWhere(['like', 'time_format', $this->time_format])
            ->andFilterWhere(['like', 'ch.username', $this->channel_name])
            ->andFilterWhere(['like', 'cam.campaign_name', $this->campaign_name])
            ->andFilterWhere(['like', 'cam.target_geo', $this->geo])
            ->andFilterWhere(['like', 'u.username', $this->bd])
            ->andFilterWhere(['like', 'o.username', $this->om])
            ->andFilterWhere(['>=', 'time', $start])
            ->andFilterWhere(['<', 'time', $end]);
        $query->groupBy([
            'clh.campaign_id',
            'clh.channel_id',]);
        $query->orderBy(['cam.campaign_name' => SORT_ASC, 'ch.username' => SORT_ASC, 'time' => SORT_DESC]);
//        var_dump($start);
//        var_dump($end);
//        var_dump($query->createCommand()->sql);
//        die();
        return $dataProvider;
    }

}
