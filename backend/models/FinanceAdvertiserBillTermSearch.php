<?php

namespace backend\models;

use common\utility\TimeZoneUtil;
use Yii;
use yii\db\Query;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use DateTime;
use DateTimeZone;
use DateInterval;
use backend\models\FinanceAdvertiserBillTerm;

/**
 * FinanceAdvertiserBillTermSearch represents the model behind the search form about `backend\models\FinanceAdvertiserBillTerm`.
 */
class FinanceAdvertiserBillTermSearch extends FinanceAdvertiserBillTerm
{
    public $adv_name;
    public $payment_term;
    public $bd;
    public $pm;
    public $excludeZero;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bill_id', 'invoice_id', 'period', 'time_zone', 'daily_cap', 'cap', 'note','adv_name','payment_term','bd','pm','start_time', 'end_time', 'status', 'excludeZero'], 'safe'],
            [['adv_id', 'clicks', 'unique_clicks', 'installs', 'match_installs', 'redirect_installs', 'redirect_match_installs', 'status', 'update_time', 'create_time'], 'integer'],
            [['pay_out', 'adv_price', 'cost', 'redirect_cost', 'revenue', 'redirect_revenue', 'receivable'], 'number'],
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
        $query = FinanceAdvertiserBillTerm::find();
        $query->alias("fab");

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' =>[
                'attributes' => [
                    'revenue' => [
                        'asc' => ['revenue' => SORT_ASC],
                        'desc' => ['revenue' => SORT_DESC],
                    ],
                ],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->select([
            'fab.*',
        ]);

        $query->leftJoin("advertiser adv",'fab.adv_id = adv.id');
        $query->leftJoin("user u",'u.id = adv.bd');
        // grid filtering conditions
        $query->andFilterWhere([
            'adv_id' => $this->adv_id,
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
            'receivable' => $this->receivable,
            'fab.status' => $this->status,
            'update_time' => $this->update_time,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'bill_id', $this->bill_id])
            ->andFilterWhere(['like', 'invoice_id', $this->invoice_id])
            ->andFilterWhere(['like', 'period', $this->period])
            ->andFilterWhere(['like', 'time_zone', $this->time_zone])
            ->andFilterWhere(['like', 'daily_cap', $this->daily_cap])
            ->andFilterWhere(['like', 'cap', $this->cap])
            ->andFilterWhere(['<>', 'fab.status', 0])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'adv.payment_term', $this->payment_term])
            ->andFilterWhere(['like', 'u.username', $this->bd])
            ->andFilterWhere(['like', 'adv.username', $this->adv_name]);

        $start = new DateTime($this->start_time);
        $end = new DateTime($this->end_time);
        $start_date = $start->sub(new DateInterval('P1D'));
        $end_date = $end->add(new DateInterval('P1M1D'));
        $start_date = $start_date->getTimestamp();
        $end_date = $end_date->getTimestamp();
        $query->andFilterWhere(['>=', 'fab.start_time', $start_date])
            ->andFilterWhere(['<', 'fab.end_time', $end_date]);

        if ($this->excludeZero == 1){
            $query->andFilterWhere(['<>', 'fab.revenue', 0]);
        }

        if (\Yii::$app->user->can('admin')) {
            $query->andFilterWhere(['like', 'u.username', $this->bd]);
        } else {
            $query->andFilterWhere(['adv.bd' => \Yii::$app->user->id]);
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
    public function receivableSearch($params)
    {
        $query = FinanceAdvertiserBillTerm::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' =>[
                'attributes' => [
                    'revenue' => [
                        'asc' => ['revenue' => SORT_ASC],
                        'desc' => ['revenue' => SORT_DESC],
                    ],
                ],
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
            ->andFilterWhere(['<>', 'status', 0]);

        if ($dataProvider->getSort()->getOrders()==null){
            $query->orderBy([ 'start_time' => SORT_DESC]);
        }
        return $dataProvider;
    }

    public function overviewSearch($params)
    {
        $query = FinanceAdvertiserBillTerm::find();
        $query->alias("fab");

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' =>[
                'attributes' => [
                    'revenue' => [
                        'asc' => ['revenue' => SORT_ASC],
                        'desc' => ['revenue' => SORT_DESC],
                        'default' => SORT_DESC,
                    ],
                ],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->select([
            'fab.*',
        ]);

        $query->leftJoin("advertiser adv",'fab.adv_id = adv.id');
        $query->leftJoin("user u0",'u0.id = adv.bd');
        $query->leftJoin("user u1",'u1.id = adv.pm');
        // grid filtering conditions
        $query->andFilterWhere([
            'adv_id' => $this->adv_id,
            'fab.status' => $this->status,
            'update_time' => $this->update_time,
            'create_time' => $this->create_time,
        ]);

        $start = TimeZoneUtil::getPrevMonthLastDayTime($this->start_time);
        $end_time = TimeZoneUtil::getNextMonthFirstDayTime($this->end_time);
        $end_time =  $end_time + 24*60*60;
        $query->andFilterWhere(['like', 'bill_id', $this->bill_id])
            ->andFilterWhere(['like', 'invoice_id', $this->invoice_id])
            ->andFilterWhere(['like', 'period', $this->period])
            ->andFilterWhere(['like', 'time_zone', $this->time_zone])
            ->andFilterWhere(['<>', 'fab.status', 0])
//            ->andFilterWhere(['in', 'fab.status', [6,7,8]])
            ->andFilterWhere(['like', 'adv.payment_term', $this->payment_term])
            ->andFilterWhere(['like', 'u0.username', $this->bd])
            ->andFilterWhere(['like', 'u1.username', $this->pm])
            ->andFilterWhere(['like', 'adv.username', $this->adv_name])
            ->andFilterWhere(['>','fab.start_time',$start])
            ->andFilterWhere(['<','fab.end_time',$end_time]);

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
        $query->select([
            'SUM(IF(fab.status= 1, fab.receivable, 0)) AS pending_billing,
           SUM(IF(fab.status= 2, fab.receivable, 0)) AS bd_leader_approval,
           SUM(IF(fab.status= 3, fab.receivable, 0)) AS bd_leader_reject,
           SUM(IF(fab.status= 4, fab.receivable, 0)) AS finance_approval,
           SUM(IF(fab.status= 5, fab.receivable, 0)) AS finance_reject,
           SUM(IF(fab.status= 6, fab.receivable, 0)) AS total_receivable,
           SUM(IF(fab.status= 7, fab.receivable, 0)) AS total_received,
           SUM(IF(fab.status= 8, fab.receivable, 0)) AS overdue,
           SUM(case when fab.status = 1 then 1 else 0 end) as count_pending,
           SUM(case when fab.status = 2 then 1 else 0 end) as count_bd_leader_approval,
           SUM(case when fab.status = 3 then 1 else 0 end) as count_bd_leader_reject,
           SUM(case when fab.status = 4 then 1 else 0 end) as count_finance_approval,
           SUM(case when fab.status = 5 then 1 else 0 end) as count_finance_reject,
           SUM(case when fab.status = 6 then 1 else 0 end) as count_receivable,
           SUM(case when fab.status = 7 then 1 else 0 end) as count_received,
           SUM(case when fab.status = 8 then 1 else 0 end) as count_overdue'
        ]);
        $query->from('finance_advertiser_bill_term fab');
        $query->leftJoin("advertiser adv",'fab.adv_id = adv.id');
        $query->leftJoin("user u",'u.id = adv.bd');

        $query->andFilterWhere([
            'revenue' => $this->revenue,
            'receivable' => $this->receivable,
        ]);

        // grid filtering conditions
        $query->andFilterWhere(['like', 'bill_id', $this->bill_id])
            ->andFilterWhere(['like', 'invoice_id', $this->invoice_id])
            ->andFilterWhere(['<>', 'fab.status', 0])
            ->andFilterWhere(['like', 'u.username', $this->bd])
            ->andFilterWhere(['like', 'adv.payment_term', $this->payment_term])
            ->andFilterWhere(['like', 'adv.username', $this->adv_name]);

        $start = new DateTime($this->start_time);
        $end = new DateTime($this->end_time);
        $start_date = $start->sub(new DateInterval('P1D'));
        $end_date = $end->add(new DateInterval('P1M1D'));
        $start_date = $start_date->getTimestamp();
        $end_date = $end_date->getTimestamp();
        $query->andFilterWhere(['>=', 'fab.start_time', $start_date])
            ->andFilterWhere(['<', 'fab.end_time', $end_date]);

        if (\Yii::$app->user->can('admin')) {
            $query->andFilterWhere(['like', 'u.username', $this->bd]);
        } else {
            $query->andFilterWhere(['adv.bd' => \Yii::$app->user->id]);
        }

        return $dataProvider;
    }
}
