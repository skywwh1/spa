<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\ChannelRegister;

/**
 * ChannelRegisterSearch represents the model behind the search form about `frontend\models\ChannelRegister`.
 */
class ChannelRegisterSearch extends ChannelRegister
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'channel_id'], 'integer'],
            [['vertical', 'offer_type', 'other_network', 'vertical_interested', 'special_offer', 'regions', 'traffic_type', 'best_time', 'time_zone', 'suggested_am', 'additional_notes', 'another_info'], 'safe'],
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
        $query = ChannelRegister::find();

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
        ]);

        $query->andFilterWhere(['like', 'vertical', $this->vertical])
            ->andFilterWhere(['like', 'offer_type', $this->offer_type])
            ->andFilterWhere(['like', 'other_network', $this->other_network])
            ->andFilterWhere(['like', 'vertical_interested', $this->vertical_interested])
            ->andFilterWhere(['like', 'special_offer', $this->special_offer])
            ->andFilterWhere(['like', 'regions', $this->regions])
            ->andFilterWhere(['like', 'traffic_type', $this->traffic_type])
            ->andFilterWhere(['like', 'best_time', $this->best_time])
            ->andFilterWhere(['like', 'time_zone', $this->time_zone])
            ->andFilterWhere(['like', 'suggested_am', $this->suggested_am])
            ->andFilterWhere(['like', 'additional_notes', $this->additional_notes])
            ->andFilterWhere(['like', 'another_info', $this->another_info]);

        return $dataProvider;
    }
}
