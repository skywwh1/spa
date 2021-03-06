<?php

namespace backend\models;

use common\models\Channel;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use DateTime;
use DateTimeZone;
use DateInterval;
use yii\db\Query;
use backend\models\FinanceDeduction;

/**
 * FinanceDeductionSearch represents the model behind the search form about `backend\models\FinanceDeduction`.
 */
class FinanceDeductionSearch extends FinanceDeduction
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
            [['id', 'campaign_id', 'channel_id', 'installs', 'match_installs', 'type', 'status', 'create_time', 'update_time'], 'integer'],
            [['adv_bill_id', 'channel_bill_id', 'timezone', 'adv', 'pm', 'bd', 'om', 'note','month','channel_name','campaign_name','master_channel', 'start_date', 'end_date',], 'safe'],
            [['cost', 'deduction_value', 'deduction_cost', 'deduction_revenue', 'revenue', 'margin'], 'number'],
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
        $query = FinanceDeduction::find();
        $query->alias("fd");
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
            'fd.id' => $this->id,
            'campaign_id' => $this->campaign_id,
            'channel_id' => $this->channel_id,
//            'start_date' => $this->start_date,
//            'end_date' => $this->end_date,
            'installs' => $this->installs,
            'match_installs' => $this->match_installs,
            'cost' => $this->cost,
            'deduction_value' => $this->deduction_value,
            'fd.type' => $this->type,
            'deduction_cost' => $this->deduction_cost,
            'deduction_revenue' => $this->deduction_revenue,
            'revenue' => $this->revenue,
            'margin' => $this->margin,
            'fd.status' => $this->status,
            'fd.create_time' => $this->create_time,
            'fd.update_time' => $this->update_time,
        ]);

        $query->leftJoin('channel ch', 'fd.channel_id = ch.id');
        $query->leftJoin('campaign camp', 'fd.campaign_id = camp.id');

        $query->andFilterWhere(['like', 'adv_bill_id', $this->adv_bill_id])
            ->andFilterWhere(['like', 'channel_bill_id', $this->channel_bill_id])
            ->andFilterWhere(['like', 'timezone', $this->timezone])
            ->andFilterWhere(['like', 'adv', $this->adv])
            ->andFilterWhere(['like', 'fd.pm', $this->pm])
            ->andFilterWhere(['like', 'bd', $this->bd])
            ->andFilterWhere(['like', 'fd.om', $this->om])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'adv_bill_id', $this->month])
            ->andFilterWhere(['like', 'camp.campaign_name', $this->campaign_name])
            ->andFilterWhere(['like', 'ch.username', $this->channel_name]);

        if (!empty($this->time_zone)){
            $start = new \DateTime($this->start_date, new DateTimeZone($this->time_zone));
            $end = new DateTime($this->end_date, new DateTimeZone($this->time_zone));
            $start_date = $start->getTimestamp();
            $end_date = $end->add(new DateInterval('P1D'));
            $end_date = $end_date->getTimestamp();
            $query->andFilterWhere(['>=', 'fd.start_date', $start_date])
                ->andFilterWhere(['<', 'fd.end_date', $end_date]);
        }
        $query->orderBy(['fd.id' => SORT_DESC]);
        return $dataProvider;
    }

    /**
     * @param $params
     * @return ActiveDataProvider
     */
    public function financeDeductionSearch($params)
    {
        $query = FinanceDeduction::find();
        $query->alias("fd");
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
            'channel_bill_id' => $this->channel_bill_id,
        ]);

        return $dataProvider;
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

        $query->select([
            'SUM(deduction_cost) AS deduction_cost,
            SUM(deduction_revenue) AS deduction_revenue,
            SUM(IF(fd.status= 0, fd.revenue, 0)) AS communicating_revenue,
           SUM(IF(fd.status= 0, fd.cost, 0)) AS communicating_cost,
           SUM(IF(fd.status= 1, fd.revenue, 0)) AS confirm_revenue,
           SUM(IF(fd.status= 1, fd.cost, 0)) AS confirm_cost,
           SUM(IF(fd.status= 2, fd.revenue, 0)) AS compensated_revenue,
           SUM(IF(fd.status= 2, fd.cost, 0)) AS compensated_cost'
        ]);
        $query->from('finance_deduction fd');
        $query->leftJoin('channel ch', 'fd.channel_id = ch.id');
        $query->leftJoin('campaign cam', 'fd.campaign_id = cam.id');

        $query->andFilterWhere(['like', 'adv_bill_id', $this->adv_bill_id])
            ->andFilterWhere(['like', 'channel_bill_id', $this->channel_bill_id])
            ->andFilterWhere(['like', 'fd.adv', $this->adv])
            ->andFilterWhere(['like', 'fd.pm', $this->pm])
            ->andFilterWhere(['like', 'fd.bd', $this->bd])
            ->andFilterWhere(['like', 'fd.om', $this->om]);

        // grid filtering conditions
        $query->andFilterWhere([
            'campaign_id' => $this->campaign_id,
            'channel_id' => $this->channel_id,
        ]);

        $query->andFilterWhere(['like', 'ch.username', $this->channel_name])
            ->andFilterWhere(['like', 'cam.campaign_name', $this->campaign_name]);

        if (!empty($this->time_zone)){
            $start = new DateTime($this->start_date, new DateTimeZone($this->time_zone));
            $end = new DateTime($this->end_date, new DateTimeZone($this->time_zone));
            $start_date = $start->getTimestamp();
            $end_date = $end->add(new DateInterval('P1D'));
            $end_date = $end_date->getTimestamp();
            $query->andFilterWhere(['>=', 'fd.start_date', $start_date])
                ->andFilterWhere(['<', 'fd.end_date', $end_date]);
        }

        return $dataProvider;
    }
}
