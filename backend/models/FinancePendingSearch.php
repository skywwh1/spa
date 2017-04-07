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
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'campaign_id', 'channel_id', 'start_date', 'end_date', 'installs', 'match_installs', 'status', 'create_time', 'update_time'], 'integer'],
            [['adv_price', 'pay_out', 'cost', 'revenue', 'margin'], 'number'],
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
        $query = FinancePending::find();

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
            'adv_price' => $this->adv_price,
            'pay_out' => $this->pay_out,
            'cost' => $this->cost,
            'revenue' => $this->revenue,
            'margin' => $this->margin,
            'status' => $this->status,
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