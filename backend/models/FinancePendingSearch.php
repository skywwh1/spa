<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\FinancePending;

/**
 * FinancePendingSearch represents the model behind the search form about `backend\models\FinancePending`.
 */
class FinancePendingSearch extends FinancePending
{
    public $month;
    public $channel_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'adv_id', 'campaign_id', 'channel_id', 'start_date', 'end_date', 'installs', 'match_installs', 'status', 'create_time', 'update_time'], 'integer'],
            [['adv_bill_id', 'channel_bill_id', 'adv', 'pm', 'bd', 'om', 'note','month','channel_name'], 'safe'],
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

        // grid filtering conditions
        $query->andFilterWhere([
            'fp.id' => $this->id,
            'adv_id' => $this->adv_id,
            'campaign_id' => $this->campaign_id,
            'channel_id' => $this->channel_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
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

        $query->andFilterWhere(['like', 'adv_bill_id', $this->adv_bill_id])
            ->andFilterWhere(['like', 'channel_bill_id', $this->channel_bill_id])
            ->andFilterWhere(['like', 'adv', $this->adv])
            ->andFilterWhere(['like', 'fp.pm', $this->pm])
            ->andFilterWhere(['like', 'bd', $this->bd])
            ->andFilterWhere(['like', 'fp.om', $this->om])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'adv_bill_id', $this->month])
            ->andFilterWhere(['like', 'ch.username', $this->channel_name]);
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
}
