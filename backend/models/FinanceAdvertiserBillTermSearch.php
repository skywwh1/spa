<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\FinanceAdvertiserBillTerm;

/**
 * FinanceAdvertiserBillTermSearch represents the model behind the search form about `backend\models\FinanceAdvertiserBillTerm`.
 */
class FinanceAdvertiserBillTermSearch extends FinanceAdvertiserBillTerm
{
    public $adv_name;
    public $payment_term;
    public $bd;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bill_id', 'invoice_id', 'period', 'time_zone', 'daily_cap', 'cap', 'note','adv_name','payment_term','bd'], 'safe'],
            [['adv_id', 'start_time', 'end_time', 'clicks', 'unique_clicks', 'installs', 'match_installs', 'redirect_installs', 'redirect_match_installs', 'status', 'update_time', 'create_time'], 'integer'],
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
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
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
}
