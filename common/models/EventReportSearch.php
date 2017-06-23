<?php

namespace common\models;

use DateInterval;
use DateTime;
use DateTimeZone;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LogEventHourly;
use yii\db\Query;

/**
 * EventReportSearch represents the model behind the search form about `common\models\LogEventHourly`.
 */
class EventReportSearch extends LogEventHourly
{
    public $type;
    public $start;
    public $end;
    public $time_zone;
    public $channel_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'campaign_id', 'channel_id', 'time', 'match_total', 'total', 'create_time'], 'integer'],
            [['event'], 'safe'],
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
        $query = LogEventHourly::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'campaign_id' => $this->campaign_id,
            'channel_id' => $this->channel_id,
            'time' => $this->time,
            'match_total' => $this->match_total,
            'total' => $this->total,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'event', $this->event]);
        return $dataProvider;
    }

    public function dailySearch($params)
    {

        $query = new Query();
//        $query->alias('clh');

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
            'ch.username channel_name',
            'cam.campaign_name campaign_name',
            'clh.campaign_id',
            'clh.channel_id',
            'clh.event',
            'UNIX_TIMESTAMP(FROM_UNIXTIME(clh.time, "%Y-%m-%d")) timestamp',
            'SUM(clh.clicks) clicks',
            'SUM(clh.match_total) unique_clicks',
            'SUM(clh.total) installs',
            'u.username om',

        ]);
        $query->from('log_event_hourly clh');
        $query->leftJoin('channel ch', 'clh.channel_id = ch.id');
        $query->leftJoin('campaign cam', 'clh.campaign_id = cam.id');
        $query->leftJoin('user u', 'ch.om = u.id');
        // grid filtering conditions
        $query->andFilterWhere([
            'clh.campaign_id' => $this->campaign_id,
            'clh.channel_id' => $this->channel_id,
            'ch.username' => $this->channel_name,
        ]);

        $query->andFilterWhere(['like', 'ch.username', $this->channel_name])
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
            'clh.event',
            'timestamp',
        ]);

//        if ($dataProvider->getSort()->getOrders() == null) {
//            $query->orderBy(['ch.username' => SORT_ASC, 'cam.campaign_name' => SORT_ASC, 'time' => SORT_DESC]);
//        }
        return $dataProvider;
    }

    public function hourlySearch($queryParams)
    {
    }

    public function sumSearch($queryParams)
    {
    }

    public function summarySearch($params)
    {
        $query = new Query();

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
            'SUM(clh.clicks) clicks',
            'SUM(clh.unique_clicks) unique_clicks',
            'SUM(clh.installs) installs',
            'SUM(clh.match_installs) match_installs',
            'SUM(clh.cost) cost',
            'SUM(clh.revenue) revenue',
            'SUM(clh.redirect_installs) redirect_installs',
            'SUM(clh.redirect_match_installs) redirect_match_installs',
            'SUM(clh.redirect_cost) redirect_cost',
            'SUM(clh.redirect_revenue) redirect_revenue',

        ]);
        $query->from('campaign_log_hourly clh');
        $query->leftJoin('channel ch', 'clh.channel_id = ch.id');
        $query->leftJoin('campaign cam', 'clh.campaign_id = cam.id');
        $query->leftJoin('user u', 'ch.om = u.id');
        // grid filtering conditions
        $query->andFilterWhere([
            'campaign_id' => $this->campaign_id,
            'channel_id' => $this->channel_id,
            'ch.username' => $this->channel_name,
        ]);

        $query->andFilterWhere(['like', 'ch.username', $this->channel_name])
            ->andFilterWhere(['>=', 'time', $start])
            ->andFilterWhere(['<', 'time', $end]);

//        if (\Yii::$app->user->can('admin')) {
//            $query->andFilterWhere(['like', 'u.username', $this->om]);
//        } else {
//            $query->andFilterWhere(['ch.om' => \Yii::$app->user->id]);
//        }
        return $dataProvider;
    }
}
