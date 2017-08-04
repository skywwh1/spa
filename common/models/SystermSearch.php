<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\System;

/**
 * SystermSearch represents the model behind the search form about `common\models\System`.
 */
class SystermSearch extends System
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['value', 'name', 'post_parameter', 'mark', 'note'], 'safe'],
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
        $query = System::find();

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
        ]);

        $query->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'post_parameter', $this->post_parameter])
            ->andFilterWhere(['like', 'mark', $this->mark])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
