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
    public $timestamp;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'campaign_id', 'channel_id', 'time', 'match_total', 'total', 'create_time'], 'integer'],
            [['event','start','end','type','channel_name'], 'safe'],
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
     * @param $params
     * @param $column_names
     * @return ActiveDataProvider
     */
    public function search($params,$column_names)
    {
        // add conditions that should always apply here
        $case = '';
        foreach ($column_names as $key =>$item){
            if ($key == count($column_names)-1){
                $case .= "case event when '$item' then total else 0 end as '$item'";
            } else {
                $case .= "case event when '$item' then total else 0 end as '$item',";
            }
        }
        $query = LogEventHourly::findBySql('SELECT campaign_id,channel_id,time,'.$case.'  FROM log_event_hourly group by campaign_id');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'campaign_id' => $this->campaign_id,
            'channel_id' => $this->channel_id,
            'match_total' => $this->match_total,
            'total' => $this->total,
            'create_time' => $this->create_time,
        ]);
        $query->andFilterWhere(['like', 'event', $this->event]);
        $query->andFilterWhere(['>=', 'time', $this->start]);
        $query->andFilterWhere(['<', 'time', $this->end]);

        $query->groupBy(['campaign_id']);

        if ($dataProvider->getSort()->getOrders()==null){
            $query->orderBy(['time' => SORT_DESC]);
        }
        return $dataProvider;
    }

    public function dailySearch($params)
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
        if (empty($this->campaign_id)){
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
            'UNIX_TIMESTAMP(FROM_UNIXTIME(clh.time, "%Y-%m-%d")) timestamp',
            'SUM(clh.match_installs) match_installs',
            'SUM(clh.installs) installs',
        ]);
        $query->from('campaign_log_sub_channel_hourly clh');
        $query->leftJoin('channel ch', 'clh.channel_id = ch.id');
        $query->leftJoin('campaign cam', 'clh.campaign_id = cam.id');
        // grid filtering conditions
        $query->andFilterWhere([
            'clh.campaign_id' => $this->campaign_id,
            'clh.channel_id' => $this->channel_id,
            'ch.username' => $this->channel_name,
        ]);

        $query->andFilterWhere(['like', 'ch.username', $this->channel_name])
            ->andFilterWhere(['>=', 'time', $start])
            ->andFilterWhere(['<', 'time', $end]);

        $query->groupBy([
            'clh.campaign_id',
            'channel_id',
            'timestamp',
        ]);

        if ($dataProvider->getSort()->getOrders() == null) {
            $query->orderBy(['time' => SORT_DESC]);
        }
        return $dataProvider;
    }

    public function SummarySearch($params)
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
        if (empty($this->campaign_id)){
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
            'sum(clh.match_installs)',
            'sum(clh.installs)',
        ]);
        $query->from('campaign_log_sub_channel_hourly clh');
        $query->leftJoin('channel ch', 'clh.channel_id = ch.id');
        $query->leftJoin('campaign cam', 'clh.campaign_id = cam.id');
        // grid filtering conditions
        $query->andFilterWhere([
            'clh.campaign_id' => $this->campaign_id,
            'clh.channel_id' => $this->channel_id,
            'ch.username' => $this->channel_name,
        ]);

        $query->andFilterWhere(['like', 'ch.username', $this->channel_name])
            ->andFilterWhere(['>=', 'time', $start])
            ->andFilterWhere(['<', 'time', $end]);

        $query->groupBy([
            'clh.campaign_id',
            'channel_id',
        ]);

        if ($dataProvider->getSort()->getOrders() == null) {
            $query->orderBy(['time' => SORT_DESC]);
        }
        return $dataProvider;
    }

    public function dynamicSummarySearch($params)
    {
        $query = LogEventHourly::find();
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        if (empty($this->campaign_id)){
            return null;
        }

        $start = new DateTime($this->start, new DateTimeZone($this->time_zone));
        $end = new DateTime($this->end, new DateTimeZone($this->time_zone));
        $end = $end->add(new DateInterval('P1D'));
        $start = $start->getTimestamp();
        $end = $end->getTimestamp();

        $query->select([
            'campaign_id',
            'channel_id',
            'ch_subid',
            'event',
            'SUM(match_total) match_total',
            'SUM(total) total',
        ]);
        // grid filtering conditions
        $query->andFilterWhere([
            'campaign_id' => $this->campaign_id,
            'channel_id' => $this->channel_id,
            'time' => $this->time,
        ]);

        $query->andFilterWhere(['>=', 'time', $start])
        ->andFilterWhere(['<', 'time', $end]);

        $query->groupBy([
            'campaign_id',
            'channel_id',
        ]);

        if ($dataProvider->getSort()->getOrders()==null){
            $query->orderBy(['time' => SORT_DESC]);
        }
        return $dataProvider;
    }

    public function dynamicDailySearch($params)
    {
        $query = LogEventHourly::find();
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
        if (empty($this->campaign_id)){
            return null;
        }

        $start = new DateTime($this->start, new DateTimeZone($this->time_zone));
        $end = new DateTime($this->end, new DateTimeZone($this->time_zone));
        $end = $end->add(new DateInterval('P1D'));
        $start = $start->getTimestamp();
        $end = $end->getTimestamp();

        $query->select([
            'campaign_id',
            'channel_id',
            'ch_subid',
            'UNIX_TIMESTAMP(FROM_UNIXTIME(time, "%Y-%m-%d")) timestamp',
            'event',
            'SUM(match_total) match_total',
            'SUM(total) total',
        ]);
        // grid filtering conditions
        $query->andFilterWhere([
            'campaign_id' => $this->campaign_id,
            'channel_id' => $this->channel_id,
            'time' => $this->time,
        ]);

        $query->andFilterWhere(['>=', 'time', $start])
            ->andFilterWhere(['<', 'time', $end]);

        $query->groupBy([
            'campaign_id',
            'channel_id',
            'timestamp',
        ]);

        if ($dataProvider->getSort()->getOrders()==null){
            $query->orderBy(['time' => SORT_DESC]);
        }
        return $dataProvider;
    }
}