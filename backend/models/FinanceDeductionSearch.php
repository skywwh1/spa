<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\FinanceDeduction;

/**
 * FinanceDeductionSearch represents the model behind the search form about `backend\models\FinanceDeduction`.
 */
class FinanceDeductionSearch extends FinanceDeduction
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'campaign_id', 'channel_id', 'start_date', 'end_date', 'installs', 'match_installs', 'status', 'type', 'create_time', 'update_time'], 'integer'],
            [['cost', 'deduction_value', 'deduction_cost', 'deduction_revenue', 'revenue', 'margin'], 'number'],
            [['adv', 'pm', 'bd', 'om', 'note'], 'safe'],
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
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'installs' => $this->installs,
            'match_installs' => $this->match_installs,
            'cost' => $this->cost,
            'deduction_value' => $this->deduction_value,
            'deduction_cost' => $this->deduction_cost,
            'deduction_revenue' => $this->deduction_revenue,
            'revenue' => $this->revenue,
            'margin' => $this->margin,
            'status' => $this->status,
            'type' => $this->type,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'adv', $this->adv])
            ->andFilterWhere(['like', 'pm', $this->pm])
            ->andFilterWhere(['like', 'bd', $this->bd])
            ->andFilterWhere(['like', 'om', $this->om])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
