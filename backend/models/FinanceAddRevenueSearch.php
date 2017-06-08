<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\FinanceAddRevenue;

/**
 * FinanceAddRevenueSearch represents the model behind the search form about `backend\models\FinanceAddRevenue`.
 */
class FinanceAddRevenueSearch extends FinanceAddRevenue
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'advertiser_id', 'create_time', 'update_time'], 'integer'],
            [['advertiser_bill_id', 'timezone', 'om', 'note'], 'safe'],
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
        $query = FinanceAddRevenue::find();
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
            'advertiser_id' => $this->advertiser_id,
            'revenue' => $this->revenue,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'advertiser_bill_id'=> $this->advertiser_bill_id
        ]);

        $query->andFilterWhere(['like', 'timezone', $this->timezone])
            ->andFilterWhere(['like', 'om', $this->om])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
