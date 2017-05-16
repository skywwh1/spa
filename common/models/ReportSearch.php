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
 * ReportSearch represents the model behind the search form about `common\models\Deliver`.
 */
class ReportSearch extends CampaignLogHourly
{
    public $time_zone;
    public $campaign_name;
    public $channel_name;
    public $type;
    public $start;
    public $end;
    public $advertiser;
    public $om;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign_id', 'channel_id', 'time', 'clicks', 'unique_clicks', 'installs', 'match_installs', 'campaign_name', 'channel_name', 'advertiser', 'om'], 'safe'],
            [['time_format', 'daily_cap', 'type', 'start', 'end', 'time_zone'], 'safe'],
            [['pay_out', 'adv_price'], 'number'],
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
//        $query = Deliver::find();
//        $query->alias('d');
//        // add conditions that should always apply here
//
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//            'sort' =>[
//                'attributes' => [
//                    'campaign_id' => [
//                        'asc' => ['campaign_id' => SORT_ASC],
//                        'desc' => ['campaign_id' => SORT_DESC],
//                    ],
//                    'campaign_name' => [
//                        'asc' => ['ca.campaign_name' => SORT_ASC],
//                        'desc' => ['ca.campaign_name' => SORT_DESC],
//                    ],
//                    'campaign_uuid' => [
//                        'asc' => ['campaign_uuid' => SORT_ASC],
//                        'desc' => ['campaign_uuid' => SORT_DESC],
//                    ],
//                    'channel_id' => [
//                        'asc' => ['ch.id' => SORT_ASC],
//                        'desc' => ['ch.id' => SORT_DESC],
//                    ],
//                    'channel_name' => [
//                        'asc' => ['ch.username' => SORT_ASC],
//                        'desc' => ['ch.username' => SORT_DESC],
//                    ],
//                    'cvr' => [
//                        'asc' => ['cvr' => SORT_ASC],
//                        'desc' => ['cvr' => SORT_DESC],
//                    ],
//                    'cost' => [
//                        'asc' => ['cost' => SORT_ASC],
//                        'desc' => ['cost' => SORT_DESC],
//                    ],
//                    'match_install' => [
//                        'asc' => ['match_install' => SORT_ASC],
//                        'desc' => ['match_install' => SORT_DESC],
//                    ],
//                    'match_cvr' => [
//                        'asc' => ['match_cvr' => SORT_ASC],
//                        'desc' => ['match_cvr' => SORT_DESC],
//                    ],
//                    'revenue' => [
//                        'asc' => ['revenue' => SORT_ASC],
//                        'desc' => ['revenue' => SORT_DESC],
//                    ],
//                ],
//            ]
//        ]);
//
//        $this->load($params);
//
//        if (!$this->validate()) {
//            // uncomment the following line if you do not want to return any records when validation fails
//            // $query->where('0=1');
//            return $dataProvider;
//        }
//
//        $query->joinWith('campaign ca');
//        $query->joinWith('channel ch');
//        // grid filtering conditions
//        $query->andFilterWhere([
//            'campaign_id' => $this->campaign_id,
//            'channel_id' => $this->channel_id,
//            'adv_price' => $this->adv_price,
//            'pay_out' => $this->pay_out,
//            'daily_cap' => $this->daily_cap,
//            'actual_discount' => $this->actual_discount,
//            'discount' => $this->discount,
//            'is_run' => $this->is_run,
//            'create_time' => $this->create_time,
//            'click' => $this->click,
//            'unique_click' => $this->unique_click,
//            'install' => $this->install,
//            'cvr' => $this->cvr,
//            'cost' => $this->cost,
//            'match_install' => $this->match_install,
//            'match_cvr' => $this->match_cvr,
//            'revenue' => $this->revenue,
//            'def' => $this->def,
//            'deduction_percent' => $this->deduction_percent,
//            'profit' => $this->profit,
//            'margin' => $this->margin,
//        ]);
//        $query->andFilterWhere(['like', 'campaign_uuid', $this->campaign_uuid])
//            ->andFilterWhere(['like', 'track_url', $this->track_url])
//            ->andFilterWhere(['like', 'note', $this->note])
//            ->andFilterWhere(['like', 'ca.campaign_name', $this->campaign_name])
//            ->andFilterWhere(['like', 'ch.username', $this->channel_name]);
//
//        if ($dataProvider->getSort()->getOrders()==null){
//            $query->orderBy(['click' => SORT_DESC, 'ccl.update_time' => SORT_DESC]);
//        }
//
//        return $dataProvider;
//    }

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

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'campaign_id' => [
                        'asc' => ['campaign_id' => SORT_ASC],
                        'desc' => ['campaign_id' => SORT_DESC],
                    ],
                    'campaign_name' => [
                        'asc' => ['cam.campaign_name' => SORT_ASC],
                        'desc' => ['cam.campaign_name' => SORT_DESC],
                    ],
                    'campaign_uuid' => [
                        'asc' => ['campaign_uuid' => SORT_ASC],
                        'desc' => ['campaign_uuid' => SORT_DESC],
                    ],
                    'channel_id' => [
                        'asc' => ['ch.id' => SORT_ASC],
                        'desc' => ['ch.id' => SORT_DESC],
                    ],
                    'channel_name' => [
                        'asc' => ['ch.username' => SORT_ASC],
                        'desc' => ['ch.username' => SORT_DESC],
                    ],
                    'cost' => [
                        'asc' => ['cost' => SORT_ASC],
                        'desc' => ['cost' => SORT_DESC],
                    ],
                    'clicks' => [
                        'asc' => ['clicks' => SORT_ASC],
                        'desc' => ['clicks' => SORT_DESC],
                    ],
                    'match_install' => [
                        'asc' => ['match_install' => SORT_ASC],
                        'desc' => ['match_install' => SORT_DESC],
                    ],
                    'revenue' => [
                        'asc' => ['revenue' => SORT_ASC],
                        'desc' => ['revenue' => SORT_DESC],
                    ],
                    'unique_clicks' => [
                        'asc' => ['unique_clicks' => SORT_ASC],
                        'desc' => ['unique_clicks' => SORT_DESC],
                    ],
                    'installs' => [
                        'asc' => ['installs' => SORT_ASC],
                        'desc' => ['installs' => SORT_DESC],
                    ],
                    'match_installs' => [
                        'asc' => ['match_installs' => SORT_ASC],
                        'desc' => ['match_installs' => SORT_DESC],
                    ],
                    'pay_out' => [
                        'asc' => ['pay_out' => SORT_ASC],
                        'desc' => ['pay_out' => SORT_DESC],
                    ],
                ],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        if (empty($this->campaign_id) && empty($this->campaign_name)) {
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
            'clh.time timestamp',
            'clh.time_format',
            'clh.clicks',
            'clh.unique_clicks',
            'clh.installs',
            'clh.match_installs',
            'clh.pay_out',
            'clh.adv_price',
            'clh.cost',
            'clh.revenue',
            'u.username om',
        ]);

        $query->from('campaign_log_hourly clh');
        $query->leftJoin('channel ch', 'clh.channel_id = ch.id');
        $query->leftJoin('campaign cam', 'clh.campaign_id = cam.id');
        $query->leftJoin('user u', 'ch.om = u.id');

        // grid filtering conditions
        $query->andFilterWhere([
            'campaign_id' => $this->campaign_id,
            'channel_id' => $this->channel_id,
        ]);

        $query->andFilterWhere(['like', 'time_format', $this->time_format])
            ->andFilterWhere(['like', 'cam.campaign_name', $this->campaign_name])
//            ->andFilterWhere(['like', 'adv.username', $this->advertiser])
            ->andFilterWhere(['like', 'u.username', $this->om])
            ->andFilterWhere(['>=', 'time', $start])
            ->andFilterWhere(['<', 'time', $end]);

        if ($dataProvider->getSort()->getOrders() == null) {
            $query->orderBy(['ch.username' => SORT_ASC, 'cam.campaign_name' => SORT_ASC, 'time' => SORT_DESC]);
        }

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function dailySearch($params)
    {
        $query = new Query();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'campaign_id' => [
                        'asc' => ['campaign_id' => SORT_ASC],
                        'desc' => ['campaign_id' => SORT_DESC],
                    ],
                    'campaign_name' => [
                        'asc' => ['cam.campaign_name' => SORT_ASC],
                        'desc' => ['cam.campaign_name' => SORT_DESC],
                    ],
                    'campaign_uuid' => [
                        'asc' => ['campaign_uuid' => SORT_ASC],
                        'desc' => ['campaign_uuid' => SORT_DESC],
                    ],
                    'channel_id' => [
                        'asc' => ['ch.id' => SORT_ASC],
                        'desc' => ['ch.id' => SORT_DESC],
                    ],
                    'channel_name' => [
                        'asc' => ['ch.username' => SORT_ASC],
                        'desc' => ['ch.username' => SORT_DESC],
                    ],
                    'cost' => [
                        'asc' => ['cost' => SORT_ASC],
                        'desc' => ['cost' => SORT_DESC],
                    ],
                    'clicks' => [
                        'asc' => ['clicks' => SORT_ASC],
                        'desc' => ['clicks' => SORT_DESC],
                    ],
                    'match_install' => [
                        'asc' => ['match_install' => SORT_ASC],
                        'desc' => ['match_install' => SORT_DESC],
                    ],
                    'revenue' => [
                        'asc' => ['revenue' => SORT_ASC],
                        'desc' => ['revenue' => SORT_DESC],
                    ],
                    'unique_clicks' => [
                        'asc' => ['unique_clicks' => SORT_ASC],
                        'desc' => ['unique_clicks' => SORT_DESC],
                    ],
                    'installs' => [
                        'asc' => ['installs' => SORT_ASC],
                        'desc' => ['installs' => SORT_DESC],
                    ],
                    'match_installs' => [
                        'asc' => ['match_installs' => SORT_ASC],
                        'desc' => ['match_installs' => SORT_DESC],
                    ],
                    'pay_out' => [
                        'asc' => ['pay_out' => SORT_ASC],
                        'desc' => ['pay_out' => SORT_DESC],
                    ],
                    'adv_price' => [
                        'asc' => ['adv_price' => SORT_ASC],
                        'desc' => ['adv_price' => SORT_DESC],
                    ],
                    'om' => [
                        'asc' => ['om' => SORT_ASC],
                        'desc' => ['om' => SORT_DESC],
                    ],
                ],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        if (empty($this->campaign_id) && empty($this->campaign_name)) {
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
            'u.username om',
            'UNIX_TIMESTAMP(FROM_UNIXTIME(clh.time, "%Y-%m-%d")) timestamp',
            'SUM(clh.clicks) clicks',
            'SUM(clh.unique_clicks) unique_clicks',
            'SUM(clh.installs) installs',
            'SUM(clh.match_installs) match_installs',
            'AVG(clh.pay_out) pay_out',
            'AVG(clh.adv_price) adv_price',
            'SUM(clh.cost) cost',
            'SUM(clh.revenue) revenue',
        ]);

        $query->from('campaign_log_hourly clh');
        $query->leftJoin('channel ch', 'clh.channel_id = ch.id');
        $query->leftJoin('campaign cam', 'clh.campaign_id = cam.id');
        $query->leftJoin('user u', 'ch.om = u.id');

        // grid filtering conditions
        $query->andFilterWhere([
            'campaign_id' => $this->campaign_id,
        ]);

        $query->andFilterWhere(['like', 'time_format', $this->time_format])
            ->andFilterWhere(['like', 'cam.campaign_name', $this->campaign_name])
            ->andFilterWhere(['like', 'ch.username', $this->channel_name])
            ->andFilterWhere(['like', 'u.username', $this->om])
            ->andFilterWhere(['>=', 'time', $start])
            ->andFilterWhere(['<', 'time', $end]);

        $query->groupBy([
            'clh.campaign_id',
            'clh.channel_id',
            'timestamp']);

        if ($dataProvider->getSort()->getOrders() == null) {
            $query->orderBy(['ch.username' => SORT_ASC, 'cam.campaign_name' => SORT_ASC, 'time' => SORT_DESC]);
        }

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
        $query = new Query();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'campaign_id' => [
                        'asc' => ['campaign_id' => SORT_ASC],
                        'desc' => ['campaign_id' => SORT_DESC],
                    ],
                    'campaign_name' => [
                        'asc' => ['cam.campaign_name' => SORT_ASC],
                        'desc' => ['cam.campaign_name' => SORT_DESC],
                    ],
                    'campaign_uuid' => [
                        'asc' => ['campaign_uuid' => SORT_ASC],
                        'desc' => ['campaign_uuid' => SORT_DESC],
                    ],
                    'channel_id' => [
                        'asc' => ['ch.id' => SORT_ASC],
                        'desc' => ['ch.id' => SORT_DESC],
                    ],
                    'channel_name' => [
                        'asc' => ['ch.username' => SORT_ASC],
                        'desc' => ['ch.username' => SORT_DESC],
                    ],
                    'match_install' => [
                        'asc' => ['match_install' => SORT_ASC],
                        'desc' => ['match_install' => SORT_DESC],
                    ],
                    'cost' => [
                        'asc' => ['cost' => SORT_ASC],
                        'desc' => ['cost' => SORT_DESC],
                    ],
                    'revenue' => [
                        'asc' => ['revenue' => SORT_ASC],
                        'desc' => ['revenue' => SORT_DESC],
                    ],
                ],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        if (empty($this->campaign_id) && empty($this->campaign_name)) {
            return null;
        }
        $start = new DateTime($this->start, new DateTimeZone($this->time_zone));
        $end = new DateTime($this->end, new DateTimeZone($this->time_zone));
        $end = $end->add(new DateInterval('P1D'));
        $start = $start->getTimestamp();
        $end = $end->getTimestamp();

        $query->select([
            'cam.campaign_name campaign_name',
            'clh.campaign_id',
            'clh.channel_id',
            'u.username om',
            'SUM(clh.clicks) clicks',
            'SUM(clh.unique_clicks) unique_clicks',
            'SUM(clh.installs) installs',
            'SUM(clh.match_installs) match_installs',
            'SUM(clh.cost) cost',
            'AVG(clh.pay_out) pay_out',
            'AVG(clh.adv_price) adv_price',
            'SUM(clh.revenue) revenue',
        ]);

        $query->from('campaign_log_hourly clh');
        $query->leftJoin('channel ch', 'clh.channel_id = ch.id');
        $query->leftJoin('campaign cam', 'clh.campaign_id = cam.id');
        $query->leftJoin('user u', 'ch.om = u.id');

        // grid filtering conditions
        $query->andFilterWhere([
            'campaign_id' => $this->campaign_id,
            'channel_id' => $this->channel_id,
        ]);
        $query->andFilterWhere(['like', 'cam.campaign_name', $this->campaign_name])
            ->andFilterWhere(['like', 'ch.username', $this->channel_name])
            ->andFilterWhere(['like', 'u.username', $this->om])
            ->andFilterWhere(['>=', 'time', $start])
            ->andFilterWhere(['<', 'time', $end]);

        if ($dataProvider->getSort()->getOrders() == null) {
            $query->orderBy(['ch.username' => SORT_ASC, 'cam.campaign_name' => SORT_ASC, 'time' => SORT_DESC]);
        }

        return $dataProvider;
    }

    public function sumSearch($params)
    {
        $query = new Query();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'attributes' => [
                    'campaign_id' => [
                        'asc' => ['campaign_id' => SORT_ASC],
                        'desc' => ['campaign_id' => SORT_DESC],
                    ],
                    'campaign_name' => [
                        'asc' => ['cam.campaign_name' => SORT_ASC],
                        'desc' => ['cam.campaign_name' => SORT_DESC],
                    ],
                    'campaign_uuid' => [
                        'asc' => ['campaign_uuid' => SORT_ASC],
                        'desc' => ['campaign_uuid' => SORT_DESC],
                    ],
                    'channel_id' => [
                        'asc' => ['ch.id' => SORT_ASC],
                        'desc' => ['ch.id' => SORT_DESC],
                    ],
                    'channel_name' => [
                        'asc' => ['ch.username' => SORT_ASC],
                        'desc' => ['ch.username' => SORT_DESC],
                    ],
                    'cost' => [
                        'asc' => ['cost' => SORT_ASC],
                        'desc' => ['cost' => SORT_DESC],
                    ],
                    'clicks' => [
                        'asc' => ['clicks' => SORT_ASC],
                        'desc' => ['clicks' => SORT_DESC],
                    ],
                    'match_install' => [
                        'asc' => ['match_install' => SORT_ASC],
                        'desc' => ['match_install' => SORT_DESC],
                    ],
                    'revenue' => [
                        'asc' => ['revenue' => SORT_ASC],
                        'desc' => ['revenue' => SORT_DESC],
                    ],
                ],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        if (empty($this->campaign_id) && empty($this->campaign_name)) {
            return null;
        }
        $start = new DateTime($this->start, new DateTimeZone($this->time_zone));
        $end = new DateTime($this->end, new DateTimeZone($this->time_zone));
        $end = $end->add(new DateInterval('P1D'));
        $start = $start->getTimestamp();
        $end = $end->getTimestamp();

        $query->select([
//            'adv.username advertiser',
            'ch.username channel_name',
            'cam.campaign_name campaign_name',
            'clh.campaign_id',
            'clh.channel_id',
            'u.username om',
//            'UNIX_TIMESTAMP(FROM_UNIXTIME(clh.time, "%Y-%m-%d")) timestamp',
            'SUM(clh.clicks) clicks',
            'SUM(clh.unique_clicks) unique_clicks',
            'SUM(clh.installs) installs',
            'SUM(clh.match_installs) match_installs',
            'AVG(clh.pay_out) pay_out',
            'AVG(clh.adv_price) adv_price',
            'SUM(clh.cost) cost',
            'SUM(clh.revenue) revenue',
        ]);

        $query->from('campaign_log_hourly clh');
        $query->leftJoin('channel ch', 'clh.channel_id = ch.id');
        $query->leftJoin('campaign cam', 'clh.campaign_id = cam.id');
        $query->leftJoin('user u', 'ch.om = u.id');

        // grid filtering conditions
        $query->andFilterWhere([
            'campaign_id' => $this->campaign_id,
        ]);

        $query->andFilterWhere(['like', 'time_format', $this->time_format])
            ->andFilterWhere(['like', 'cam.campaign_name', $this->campaign_name])
            ->andFilterWhere(['like', 'ch.username', $this->channel_name])
            ->andFilterWhere(['like', 'u.username', $this->om])
            ->andFilterWhere(['>=', 'time', $start])
            ->andFilterWhere(['<', 'time', $end]);

        $query->groupBy([
            'clh.campaign_id',
            'clh.channel_id',
        ]);

        if ($dataProvider->getSort()->getOrders() == null) {
            $query->orderBy(['ch.username' => SORT_ASC, 'cam.campaign_name' => SORT_ASC, 'time' => SORT_DESC]);
        }

        return $dataProvider;
    }
}
