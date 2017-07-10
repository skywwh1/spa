<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\db\Query;
use DateInterval;
use DateTime;
use DateTimeZone;

/**
 * ChannelQualityReportSearch represents the model behind the search form about `common\models\ChannelQualityReport`.
 */
class ChannelQualityReportSearch extends CampaignLogSubChannelHourly
{
    public $column_name;
    public $column_value;
    public $read_only;
    public $channel_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign_id', 'channel_id', 'time', 'clicks', 'unique_clicks', 'installs', 'match_installs', 'redirect_installs', 'redirect_match_installs', 'create_time'], 'integer'],
            [['sub_channel', 'daily_cap', 'type', 'start', 'end', 'time_zone', 'om','channel_name'], 'safe'],
            [['pay_out', 'adv_price', 'cost', 'redirect_cost', 'revenue', 'redirect_revenue'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
//    public function search($params)
//    {
//        $query = new Query();
//
//        // add conditions that should always apply here
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//        ]);
//
//        $this->load($params);
//
//        if (!$this->validate()) {
//            return $dataProvider;
//        }
//
//        $query->addSelect([
//            'cqr.*',
//            'qdc.name column_name',
//            'qdc.value column_value',
//        ]);
//        $query->from("campaign_log_sub_channel_hourly cqr");
//        $query->leftJoin("quality_dynamic_column qdc","cqr.channel_id = qdc.channel_id and cqr.campaign_id = qdc.campaign_id and cqr.sub_channel = qdc.sub_channel and cqr.time = qdc.time");
//        // grid filtering conditions
//        $query->andFilterWhere([
//            'cqr.campaign_id' => $this->campaign_id,
//            'cqr.channel_id' => $this->channel_id,
//            'time' => $this->time,
//        ]);
//        return $dataProvider;
//    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = new Query();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        if(empty($this->campaign_id) || empty($this->channel_name)){
            return null;
        }
        $start = new DateTime($this->start, new DateTimeZone($this->time_zone));
        $end = new DateTime($this->end, new DateTimeZone($this->time_zone));
        $end = $end->add(new DateInterval('P1D'));
        $start = $start->getTimestamp();
        $end = $end->getTimestamp();
        $query->select([
            'ch.username channel_name',
            'cam.campaign_name campaign_name',
            'clh.campaign_id',
            'clh.channel_id',
            'clh.sub_channel',
            'DATE_FORMAT(clh.time_format, "%Y%m%d") AS timestamp',
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
        $query->from('campaign_log_sub_channel_hourly clh');
        $query->leftJoin('channel ch', 'clh.channel_id = ch.id');
        $query->leftJoin('campaign cam', 'clh.campaign_id = cam.id');
        $query->leftJoin('user u', 'ch.om = u.id');
        // grid filtering conditions
        $query->andFilterWhere([
            'clh.campaign_id' => $this->campaign_id,
            'clh.channel_id' => $this->channel_id,
            'sub_channel' => $this->sub_channel,
            'ch.username' => $this->channel_name,
        ]);

        $query->andFilterWhere(['like', 'ch.username', $this->channel_name])
            ->andFilterWhere(['like', 'cam.campaign_name', $this->campaign_name])
            ->andFilterWhere(['<>', 'clh.installs', 0])
            ->andFilterWhere(['>=', 'time', $start])
            ->andFilterWhere(['<', 'time', $end]);

//        if (\Yii::$app->user->can('admin')) {
//            $query->andFilterWhere(['like', 'u.username', $this->om]);
//        } else {
//            $query->andFilterWhere(['ch.om' => \Yii::$app->user->id]);
//        }
        $query->groupBy([
            'clh.campaign_id',
            'clh.channel_id',
            'clh.sub_channel',
            'timestamp',
        ]);
        if ($dataProvider->getSort()->getOrders()==null){
            $query->orderBy(['ch.username' => SORT_ASC, 'cam.campaign_name' => SORT_ASC, 'time' => SORT_DESC]);
        }
//        var_dump($start).PHP_EOL;
//        var_dump($end).PHP_EOL;
//        var_dump($query->createCommand()->sql);
//        die();
        return $dataProvider;
    }
    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function dynamicSearch($params)
    {
        $query = QualityDynamicColumn::find();
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);


        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'campaign_id' => $this->campaign_id,
            'channel_id' => $this->channel_id,
            'time' => $this->time,
            'sub_channel' => $this->sub_channel,
        ]);
        if ($dataProvider->getSort()->getOrders()==null){
            $query->orderBy(['time' => SORT_DESC]);
        }
//        var_dump($query->createCommand()->sql);
//        die();
        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function monthSearch($params)
    {
        $query = new Query();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        if(empty($this->campaign_id) || empty($this->channel_name)){
            return null;
        }
        $start = new DateTime($this->start, new DateTimeZone($this->time_zone));
        $end = new DateTime($this->end, new DateTimeZone($this->time_zone));
        $end = $end->add(new DateInterval('P1D'));
        $start = $start->getTimestamp();
        $end = $end->getTimestamp();
        $query->select([
            'ch.username channel_name',
            'cam.campaign_name campaign_name',
            'clh.campaign_id',
            'clh.channel_id',
            'clh.sub_channel',
            'DATE_FORMAT(clh.time_format, "%Y%m") AS timestamp',
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
        $query->from('campaign_log_sub_channel_hourly clh');
        $query->leftJoin('channel ch', 'clh.channel_id = ch.id');
        $query->leftJoin('campaign cam', 'clh.campaign_id = cam.id');
        $query->leftJoin('user u', 'ch.om = u.id');
        // grid filtering conditions
        $query->andFilterWhere([
            'clh.campaign_id' => $this->campaign_id,
            'clh.channel_id' => $this->channel_id,
            'sub_channel' => $this->sub_channel,
            'ch.username' => $this->channel_name,
        ]);

        $query->andFilterWhere(['like', 'ch.username', $this->channel_name])
            ->andFilterWhere(['like', 'cam.campaign_name', $this->campaign_name])
            ->andFilterWhere(['<>', 'clh.installs', 0])
            ->andFilterWhere(['>=', 'time', $start])
            ->andFilterWhere(['<', 'time', $end]);

//        if (\Yii::$app->user->can('admin')) {
//            $query->andFilterWhere(['like', 'u.username', $this->om]);
//        } else {
//            $query->andFilterWhere(['ch.om' => \Yii::$app->user->id]);
//        }
        $query->groupBy([
            'clh.campaign_id',
            'clh.channel_id',
            'clh.sub_channel',
            'timestamp',
        ]);
        if ($dataProvider->getSort()->getOrders()==null){
            $query->orderBy(['ch.username' => SORT_ASC, 'cam.campaign_name' => SORT_ASC, 'time' => SORT_DESC]);
        }
//        var_dump(Yii::$app->user->id);
//        var_dump($start).PHP_EOL;
//        var_dump($end).PHP_EOL;
//        var_dump($query->createCommand()->sql);
//        die();
        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function weekSearch($params)
    {
        $query = new Query();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }

        if(empty($this->campaign_id) || empty($this->channel_name)){
            return null;
        }
        $start = new DateTime($this->start, new DateTimeZone($this->time_zone));
        $end = new DateTime($this->end, new DateTimeZone($this->time_zone));
        $end = $end->add(new DateInterval('P1D'));
        $start = $start->getTimestamp();
        $end = $end->getTimestamp();
        $query->select([
            'ch.username channel_name',
            'cam.campaign_name campaign_name',
            'clh.campaign_id',
            'clh.channel_id',
            'clh.sub_channel',
            'DATE_FORMAT(clh.time_format, "%Y%u") AS timestamp',
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
        $query->from('campaign_log_sub_channel_hourly clh');
        $query->leftJoin('channel ch', 'clh.channel_id = ch.id');
        $query->leftJoin('campaign cam', 'clh.campaign_id = cam.id');
        $query->leftJoin('user u', 'ch.om = u.id');
        // grid filtering conditions
        $query->andFilterWhere([
            'clh.campaign_id' => $this->campaign_id,
            'clh.channel_id' => $this->channel_id,
            'sub_channel' => $this->sub_channel,
            'ch.username' => $this->channel_name,
        ]);

        $query->andFilterWhere(['like', 'ch.username', $this->channel_name])
            ->andFilterWhere(['like', 'cam.campaign_name', $this->campaign_name])
            ->andFilterWhere(['<>', 'clh.installs', 0])
            ->andFilterWhere(['>=', 'time', $start])
            ->andFilterWhere(['<', 'time', $end]);

//        if (\Yii::$app->user->can('admin')) {
//            $query->andFilterWhere(['like', 'u.username', $this->om]);
//        } else {
//            $query->andFilterWhere(['ch.om' => \Yii::$app->user->id]);
//        }
        $query->groupBy([
            'clh.campaign_id',
            'clh.channel_id',
            'clh.sub_channel',
            'timestamp',
        ]);
        if ($dataProvider->getSort()->getOrders()==null){
            $query->orderBy(['ch.username' => SORT_ASC, 'cam.campaign_name' => SORT_ASC, 'time' => SORT_DESC]);
        }
//        var_dump($start).PHP_EOL;
//        var_dump($end).PHP_EOL;
//        var_dump($query->createCommand()->sql);
//        die();
        return $dataProvider;
    }

    public function getColumnName(){
        return $this->column_name;
    }

    public function getColumnValue(){
        return $this->column_value;
    }
}
