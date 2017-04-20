<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\FinanceCompensation;

/**
 * FinanceCompensationSearch represents the model behind the search form about `backend\models\FinanceCompensation`.
 */
class FinanceCompensationSearch extends FinanceCompensation
{
    public $deduction_ids;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['deduction_id', 'status', 'editor', 'creator'], 'integer'],
            [['compensation', 'billable_cost', 'billable_revenue', 'billable_margin', 'final_margin'], 'number'],
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
        $query = FinanceCompensation::find();

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
            'deduction_id' => $this->deduction_id,
            'compensation' => $this->compensation,
            'billable_cost' => $this->billable_cost,
            'billable_revenue' => $this->billable_revenue,
            'billable_margin' => $this->billable_margin,
            'final_margin' => $this->final_margin,
            'status' => $this->status,
            'editor' => $this->editor,
            'creator' => $this->creator,
        ]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function detailSearch($params)
    {
        $query = FinanceCompensation::find();

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
        $query->where([
            'in', 'deduction_id', $this->deduction_ids
        ]);

        return $dataProvider;
    }
}
