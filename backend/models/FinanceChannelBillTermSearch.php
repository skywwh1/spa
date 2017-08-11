<?php

namespace backend\models;

use common\models\Channel;
use common\utility\TimeZoneUtil;
use Yii;
use yii\db\Query;
use yii\base\Model;
use DateTime;
use DateTimeZone;
use DateInterval;
use yii\data\ActiveDataProvider;
use backend\models\FinanceChannelBillTerm;

/**
 * FinanceChannelBillTermSearch represents the model behind the search form about `backend\models\FinanceChannelBillTerm`.
 */
class FinanceChannelBillTermSearch extends FinanceChannelBillTerm
{
    public $channel_name;
    public $bank_name;
    public $bank_address;
    public $account_nu_iban;
    public $swift;
    public $om;
    public $master_channel;
    public $level;
    public $excludeZero;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bill_id', 'invoice_id', 'period', 'time_zone', 'daily_cap', 'cap', 'note','channel_name','bank_name','bank_address','account_nu_iban','swift','om','start_time','end_time','status','master_channel','level','excludeZero'], 'safe'],
            [['channel_id', 'clicks', 'unique_clicks', 'installs', 'match_installs', 'redirect_installs', 'redirect_match_installs', 'status', 'update_time', 'create_time'], 'integer'],
            [['pay_out', 'adv_price', 'cost', 'redirect_cost', 'revenue', 'redirect_revenue', 'add_historic_cost', 'pending', 'deduction', 'compensation', 'add_cost', 'final_cost', 'actual_margin', 'paid_amount', 'payable', 'apply_prepayment', 'balance'], 'number'],
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
        $query = FinanceChannelBillTerm::find();
        $query->alias("fcb");

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' =>[
                'attributes' => [
                    'cost' => [
                        'asc' => ['cost' => SORT_ASC],
                        'desc' => ['cost' => SORT_DESC],
                    ],
                ],
//                'defaultOrder' => ['start_time' => SORT_DESC],
            ]
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
            'channel_id' => $this->channel_id,
//            'start_time' => $this->start_time,
//            'end_time' => $this->end_time,
            'clicks' => $this->clicks,
            'unique_clicks' => $this->unique_clicks,
            'installs' => $this->installs,
            'match_installs' => $this->match_installs,
            'redirect_installs' => $this->redirect_installs,
            'redirect_match_installs' => $this->redirect_match_installs,
            'pay_out' => $this->pay_out,
            'adv_price' => $this->adv_price,
            'cost' => $this->cost,
            'redirect_cost' => $this->redirect_cost,
            'revenue' => $this->revenue,
            'redirect_revenue' => $this->redirect_revenue,
            'add_historic_cost' => $this->add_historic_cost,
            'pending' => $this->pending,
            'deduction' => $this->deduction,
            'compensation' => $this->compensation,
            'add_cost' => $this->add_cost,
            'final_cost' => $this->final_cost,
            'actual_margin' => $this->actual_margin,
            'paid_amount' => $this->paid_amount,
            'payable' => $this->payable,
            'apply_prepayment' => $this->apply_prepayment,
            'balance' => $this->balance,
            'fcb.status' => $this->status,
            'update_time' => $this->update_time,
            'create_time' => $this->create_time,
        ]);

        $query->leftJoin('channel ch','fcb.channel_id = ch.id');

        $query->andFilterWhere(['like', 'bill_id', $this->bill_id])
            ->andFilterWhere(['like', 'invoice_id', $this->invoice_id])
            ->andFilterWhere(['like', 'period', $this->period])
            ->andFilterWhere(['like', 'time_zone', $this->time_zone])
            ->andFilterWhere(['like', 'daily_cap', $this->daily_cap])
            ->andFilterWhere(['like', 'cap', $this->cap])
            ->andFilterWhere(['<>', 'fcb.status', 0])
            ->andFilterWhere(['like', 'note', $this->note]);

        $query->andFilterWhere(['like', 'ch.username', $this->channel_name])
        ->andFilterWhere([ 'like', 'ch.level', $this->level]);

        $start = new DateTime($this->start_time);
        $end = new DateTime($this->end_time);
        $start_date = $start->sub(new DateInterval('P1D'));
        $end_date = $end->add(new DateInterval('P1M1D'));
        $start_date = $start_date->getTimestamp();
        $end_date = $end_date->getTimestamp();
        $query->andFilterWhere(['>=', 'fcb.start_time', $start_date])
            ->andFilterWhere(['<', 'fcb.end_time', $end_date]);

        if ($this->excludeZero == 1){
            $query->andFilterWhere(['<>', 'fcb.cost', 0]);
        }

        if (\Yii::$app->user->can('admin')) {
            $query->andFilterWhere(['like', 'u.username', $this->om]);
        } else {
            $query->andFilterWhere(['ch.om' => \Yii::$app->user->id]);
        }

        if ($dataProvider->getSort()->getOrders()==null){
            $query->orderBy([ 'start_time' => SORT_DESC]);
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
    public function payableSearch($params)
    {
        $query = FinanceChannelBillTerm::find();
        $query->alias("fcb");

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' =>[
                'attributes' => [
                    'cost' => [
                        'asc' => ['cost' => SORT_ASC],
                        'desc' => ['cost' => SORT_DESC],
                    ],
                ],
//                'defaultOrder' => ['start_time' => SORT_DESC],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'bill_id' => $this->bill_id,
        ]);

        $query->andFilterWhere(['like', 'invoice_id', $this->invoice_id])
            ->andFilterWhere(['<>', 'fcb.status', 0]);

        if ($dataProvider->getSort()->getOrders()==null){
            $query->orderBy([ 'start_time' => SORT_DESC]);
        }
        return $dataProvider;
    }

    public function overviewSearch($params)
    {
        $query = FinanceChannelBillTerm::find();
        $query->alias("fcb");

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' =>[
                'attributes' => [
                    'cost' => [
                        'asc' => ['cost' => SORT_ASC],
                        'desc' => ['cost' => SORT_DESC],
                        'default' => SORT_DESC,
                    ],
                ],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }
        $start = TimeZoneUtil::getPrevMonthLastDayTime($this->start_time);
        $end_time = TimeZoneUtil::getNextMonthFirstDayTime($this->end_time);
        $end_time =  $end_time + 24*60*60;
        $query->andFilterWhere([
            'fcb.status' => $this->status,
            'update_time' => $this->update_time,
            'create_time' => $this->create_time,
        ]);

        $query->leftJoin('channel ch','fcb.channel_id = ch.id');
        $query->leftJoin('user u','ch.om = u.id');

        $query->andFilterWhere(['like', 'bill_id', $this->bill_id])
//            ->andFilterWhere(['like', 'period', $period])
            ->andFilterWhere(['like', 'time_zone', $this->time_zone])
            ->andFilterWhere(['like', 'ch.username', $this->channel_name])
            ->andFilterWhere(['like', 'u.username', $this->om])
            ->andFilterWhere(['>','fcb.start_time',$start])
            ->andFilterWhere(['<>', 'fcb.status', 0])
            ->andFilterWhere(['<','fcb.end_time',$end_time]);

//        if (empty($this->status)){
//            $query->andFilterWhere(['in', 'fcb.status', [6,7,8]]);
//        }

        if ($dataProvider->getSort()->getOrders()==null){
            $query->orderBy([ 'start_time' => SORT_DESC]);
        }
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
        if (!empty($this->master_channel)){
            $channel_id = Channel::findByUsername($this->master_channel)->id;
            $query->andFilterWhere([ 'channel_id' => $channel_id ]);
        }
        $query->select([
            'SUM(IF(fp.status= 1, fp.payable, 0)) AS pending_billing,
           SUM(IF(fp.status= 2, fp.payable, 0)) AS om_leader_approval,
           SUM(IF(fp.status= 3, fp.payable, 0)) AS om_leader_reject,
           SUM(IF(fp.status= 4, fp.payable, 0)) AS finance_approval,
           SUM(IF(fp.status= 5, fp.payable, 0)) AS finance_reject,
           SUM(IF(fp.status= 6, fp.payable, 0)) AS total_payable,
           SUM(IF(fp.status= 7, fp.payable, 0)) AS total_paid,
           SUM(case when fp.status = 1 then 1 else 0 end) as count_pending,
           SUM(case when fp.status = 2 then 1 else 0 end) as count_om_leader_approval,
           SUM(case when fp.status = 3 then 1 else 0 end) as count_om_leader_reject,
           SUM(case when fp.status = 4 then 1 else 0 end) as count_finance_approval,
           SUM(case when fp.status = 5 then 1 else 0 end) as count_finance_reject,
           SUM(case when fp.status = 6 then 1 else 0 end) as count_payable,
           SUM(case when fp.status = 7 then 1 else 0 end) as count_paid'
        ]);
        $query->from('finance_channel_bill_term fp');
        $query->leftJoin('channel ch', 'fp.channel_id = ch.id');

        $query->andFilterWhere(['like', 'bill_id', $this->bill_id])
            ->andFilterWhere(['like', 'fp.om', $this->om]);
        // grid filtering conditions
        $query->andFilterWhere([
            'channel_id' => $this->channel_id,
            'pay_out' => $this->pay_out,
            'adv_price' => $this->adv_price,
            'ch.level' => $this->level,
        ]);

        $start = new DateTime($this->start_time);
        $end = new DateTime($this->end_time);
        $start_date = $start->sub(new DateInterval('P1D'));
        $end_date = $end->add(new DateInterval('P1M1D'));
        $start_date = $start_date->getTimestamp();
        $end_date = $end_date->getTimestamp();
        $query->andFilterWhere(['>=', 'fp.start_time', $start_date])
            ->andFilterWhere(['<', 'fp.end_time', $end_date]);

        $query->andFilterWhere(['like', 'ch.username', $this->channel_name])
              ->andFilterWhere([ 'like', 'ch.level', $this->level]);

        if (\Yii::$app->user->can('admin')) {
            $query->andFilterWhere(['like', 'u.username', $this->om]);
        } else {
            $query->andFilterWhere(['ch.om' => \Yii::$app->user->id]);
        }
        return $dataProvider;
    }
}
