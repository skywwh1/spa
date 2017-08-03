<?php

namespace common\models;

use DateInterval;
use DateTime;
use DateTimeZone;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ReportMatchInstallHourly;
use yii\db\Query;

/**
 * ReportMatchInstallHourlySearch represents the model behind the search form about `common\models\ReportMatchInstallHourly`.
 */
class ReportMatchInstallHourlySearch extends ReportMatchInstallHourly
{
    public $campaign_name;
    public $type;
    public $start;
    public $end;
    public $time_zone;
    public $timestamp;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign_id', 'time', 'advertiser_id', 'installs', 'installs_in', 'update_time', 'create_time'], 'integer'],
            [['time_format', 'daily_cap', 'type', 'start', 'end', 'time_zone', 'om','adv',], 'safe'],
            [['revenue'], 'number'],
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
    public function search($params)
    {
        $query = ReportMatchInstallHourly::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
//        var_dump($this->type);
//        die();
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'campaign_id' => $this->campaign_id,
            'time' => $this->time,
            'advertiser_id' => $this->advertiser_id,
            'installs' => $this->installs,
            'installs_in' => $this->installs_in,
            'revenue' => $this->revenue,
            'update_time' => $this->update_time,
            'create_time' => $this->create_time,
        ]);

        return $dataProvider;
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

        $query = new Query();
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
//        var_dump($this->type);
//        die();
        if (!$this->validate()) {
            return $dataProvider;
        }
//        $a = strtotime($this->start);
        $start = new DateTime($this->start, new DateTimeZone($this->time_zone));
        $end = new DateTime($this->end, new DateTimeZone($this->time_zone));
        $end = $end->add(new DateInterval('P1D'));
        $start = $start->getTimestamp();
        $end = $end->getTimestamp();
        $query->select([
            'clh.campaign_id',
            'clh.advertiser_id',
            'clh.time timestamp',
            'clh.installs',
            'clh.installs_in',
            'clh.revenue',
        ]);
        $query->from('report_match_install_hourly clh');
        // grid filtering conditions
        $query->andFilterWhere([
            'campaign_id' => $this->campaign_id,
        ]);

        $query->andFilterWhere(['>=', 'time', $start])
            ->andFilterWhere(['<', 'time', $end]);
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

//        $query = ReportChannelHourly::find();
        $query = new Query();
//        $query->alias('clh');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
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
//            'ch.username channel_name',
//            'cam.campaign_name campaign_name',
            'clh.campaign_id',
            'clh.advertiser_id',
//            'FROM_UNIXTIME(clh.time,"%Y-%m-%d") time',
            'UNIX_TIMESTAMP(FROM_UNIXTIME(clh.time, "%Y-%m-%d")) timestamp',
            'SUM(clh.installs) installs',
            'SUM(installs_in) installs_in',
            'SUM(clh.revenue) revenue',
        ]);
        $query->from('report_match_install_hourly clh');
//        $query->leftJoin('channel ch', 'clh.channel_id = ch.id');
//        $query->leftJoin('campaign cam', 'clh.campaign_id = cam.id');
//        $query->leftJoin('user u', 'ch.om = u.id');
//        $query->leftJoin('advertiser adv', 'cam.advertiser = adv.id');
        // grid filtering conditions
        $query->andFilterWhere([
            'clh.campaign_id' => $this->campaign_id,
//            'clh.channel_id' => $this->channel_id,
//            'clh.pay_out' => $this->pay_out,
//            'clh.adv_price' => $this->adv_price,
//            'ch.username' => $this->channel_name,
//            'adv.username' => $this->adv,
        ]);

        $query->andFilterWhere(['>=', 'time', $start])
            ->andFilterWhere(['<', 'time', $end]);

        $query->groupBy([
            'clh.campaign_id',
            'timestamp',
        ]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @return ActiveDataProvider
     */
    public function summarySearch($params)
    {
        $query = new Query();
//        $query->alias('clh');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
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
            'SUM(clh.installs) installs',
            'SUM(clh.installs_in) installs_in',
            'SUM(clh.revenue) revenue',
        ]);
        $query->from('report_match_install_hourly clh');


        // grid filtering conditions
        $query->andFilterWhere([
            'campaign_id' => $this->campaign_id,
        ]);

        $query->andFilterWhere(['>=', 'time', $start])
            ->andFilterWhere(['<', 'time', $end]);

        return $dataProvider;
    }

    public function sumSearch($params)
    {


//        $query = ReportChannelHourly::find();
        $query = new Query();
//        $query->alias('clh');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
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
            'clh.campaign_id',
            'clh.advertiser_id',
            'UNIX_TIMESTAMP(FROM_UNIXTIME(clh.time, "%Y-%m-%d")) timestamp',
            'SUM(clh.installs) installs',
            'SUM(installs_in) installs_in',
            'SUM(clh.revenue) revenue',
        ]);
        $query->from('report_match_install_hourly clh');

        // grid filtering conditions
        $query->andFilterWhere([
            'clh.campaign_id' => $this->campaign_id,
        ]);

        $query->andFilterWhere(['>=', 'time', $start])
            ->andFilterWhere(['<', 'time', $end]);


        $query->groupBy([
            'clh.campaign_id',
        ]);


        return $dataProvider;
    }
}
