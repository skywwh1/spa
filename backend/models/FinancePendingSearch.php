<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\FinancePending;
use common\models\Channel;
use DateTime;
use DateTimeZone;
use DateInterval;
use yii\db\Query;
/**
 * FinancePendingSearch represents the model behind the search form about `backend\models\FinancePending`.
 */
class FinancePendingSearch extends FinancePending
{
    public $month;
    public $channel_name;
    public $campaign_name;
    public $master_channel;
    public $time_zone;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'adv_id', 'campaign_id', 'channel_id',  'installs', 'match_installs', 'status', 'create_time', 'update_time'], 'integer'],
            [['adv_bill_id', 'channel_bill_id', 'adv', 'pm', 'bd', 'om', 'note','month','channel_name','campaign_name','master_channel','start_date','end_date'], 'safe'],
            [['adv_price', 'pay_out', 'cost', 'revenue', 'margin'], 'number'],
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
        $query = FinancePending::find();
        $query->alias("fp");

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

        if (!empty($this->master_channel)){
            $channel_id = Channel::findByUsername($this->master_channel)->id;
            $query->andFilterWhere([ 'channel_id' => $channel_id ]);
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'fp.id' => $this->id,
            'adv_id' => $this->adv_id,
            'campaign_id' => $this->campaign_id,
            'channel_id' => $this->channel_id,
//            'start_date' => $this->start_date,
//            'end_date' => $this->end_date,
            'installs' => $this->installs,
            'match_installs' => $this->match_installs,
            'adv_price' => $this->adv_price,
            'pay_out' => $this->pay_out,
            'cost' => $this->cost,
            'revenue' => $this->revenue,
            'margin' => $this->margin,
            'fp.status' => $this->status,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->leftJoin('channel ch', 'fp.channel_id = ch.id');
        $query->leftJoin('campaign camp', 'fp.campaign_id = camp.id');

        $query->andFilterWhere(['like', 'adv_bill_id', $this->adv_bill_id])
            ->andFilterWhere(['like', 'channel_bill_id', $this->channel_bill_id])
            ->andFilterWhere(['like', 'adv', $this->adv])
            ->andFilterWhere(['like', 'fp.pm', $this->pm])
            ->andFilterWhere(['like', 'bd', $this->bd])
            ->andFilterWhere(['like', 'fp.om', $this->om])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'campaign_name', $this->campaign_name])
            ->andFilterWhere(['like', 'adv_bill_id', $this->month])
            ->andFilterWhere(['like', 'ch.username', $this->channel_name]);
        if (!empty($this->time_zone)){
            $start = new DateTime($this->start_date, new DateTimeZone($this->time_zone));
            $end = new DateTime($this->end_date, new DateTimeZone($this->time_zone));
            $start_date = $start->getTimestamp();
            $end_date = $end->add(new DateInterval('P1D'));
            $end_date = $end_date->getTimestamp();
            $query->andFilterWhere(['>=', 'fp.start_date', $start_date])
                ->andFilterWhere(['<', 'fp.end_date', $end_date]);
        }
        $query->orderBy(['fp.id' => SORT_DESC]);
        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function financePendingSearch($params)
    {
        $query = FinancePending::find();
        $query->alias("fp");

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
            'status' => $this->status,
            'adv_id' => $this->adv_id,
            'campaign_id' => $this->campaign_id,
            'channel_id' => $this->channel_id,
            'adv_bill_id' => $this->adv_bill_id,
            'channel_bill_id' => $this->channel_bill_id,
            'adv_bill_id_new' => $this->adv_bill_id_new,
            'channel_bill_id_new' => $this->channel_bill_id_new,
        ]);

        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
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
        $query->select([
            'SUM(IF(fp.status= 0, fp.revenue, 0)) AS pending_revenue,
           SUM(IF(fp.status= 0, fp.cost, 0)) AS pending_cost,
           SUM(IF(fp.status= 1, fp.revenue, 0)) AS confirm_revenue,
           SUM(IF(fp.status= 1, fp.cost, 0)) AS confirm_cost'
        ]);
        $query->from('finance_pending fp');
        $query->leftJoin('channel ch', 'fp.channel_id = ch.id');
        $query->leftJoin('campaign cam', 'fp.campaign_id = cam.id');

        $query->andFilterWhere(['like', 'adv_bill_id', $this->adv_bill_id])
            ->andFilterWhere(['like', 'channel_bill_id', $this->channel_bill_id])
            ->andFilterWhere(['like', 'fp.adv', $this->adv])
            ->andFilterWhere(['like', 'fp.pm', $this->pm])
            ->andFilterWhere(['like', 'fp.bd', $this->bd])
            ->andFilterWhere(['like', 'fp.om', $this->om]);
        // grid filtering conditions
        $query->andFilterWhere([
            'campaign_id' => $this->campaign_id,
            'channel_id' => $this->channel_id,
            'pay_out' => $this->pay_out,
            'adv_price' => $this->adv_price,
            'ad.username' => $this->adv_name,
        ]);

        $query->andFilterWhere(['like', 'ch.username', $this->channel_name])
            ->andFilterWhere(['like', 'cam.campaign_name', $this->campaign_name])->one();
//
        if (!empty($this->time_zone)){
            $start = new DateTime($this->start_date, new DateTimeZone($this->time_zone));
            $end = new DateTime($this->end_date, new DateTimeZone($this->time_zone));
            $start_date = $start->getTimestamp();
            $end_date = $end->add(new DateInterval('P1D'));
            $end_date = $end_date->getTimestamp();
            $query->andFilterWhere(['>=', 'fp.start_date', $start_date])
                ->andFilterWhere(['<', 'fp.end_date', $end_date]);
        }

        return $dataProvider;
    }
}
