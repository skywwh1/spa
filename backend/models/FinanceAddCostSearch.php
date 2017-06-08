<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\FinanceAddCost;

/**
 * FinanceAddCostSearch represents the model behind the search form about `backend\models\FinanceAddCost`.
 */
class FinanceAddCostSearch extends FinanceAddCost
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'channel_id', 'create_time', 'update_time'], 'integer'],
            [['channel_bill_id', 'timezone', 'om', 'note'], 'safe'],
            [['cost'], 'number'],
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
        $query = FinanceAddCost::find();
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
            'channel_id' => $this->channel_id,
            'cost' => $this->cost,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'channel_bill_id'=> $this->channel_bill_id,
        ]);

        $query->andFilterWhere(['like', 'timezone', $this->timezone])
            ->andFilterWhere(['like', 'om', $this->om])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
