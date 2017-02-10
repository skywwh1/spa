<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Stream;

/**
 * StreamSearch represents the model behind the search form about `common\models\Stream`.
 */
class StreamSearch extends Stream
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'post_status', 'post_time', 'is_count', 'create_time'], 'integer'],
            [['click_uuid', 'click_id', 'cp_uid', 'ch_id', 'pl', 'tx_id', 'all_parameters', 'ip', 'redirect', 'browser', 'browser_type', 'post_link'], 'safe'],
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
        $query = Stream::find();

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
            'post_status' => 3,
            'post_time' => $this->post_time,
            'is_count' => $this->is_count,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'click_uuid', $this->click_uuid])
            ->andFilterWhere(['like', 'click_id', $this->click_id])
            ->andFilterWhere(['like', 'cp_uid', $this->cp_uid])
            ->andFilterWhere(['like', 'ch_id', $this->ch_id])
            ->andFilterWhere(['like', 'pl', $this->pl])
            ->andFilterWhere(['like', 'tx_id', $this->tx_id])
            ->andFilterWhere(['like', 'all_parameters', $this->all_parameters])
            ->andFilterWhere(['like', 'ip', $this->ip])
            ->andFilterWhere(['like', 'redirect', $this->redirect])
            ->andFilterWhere(['like', 'browser', $this->browser])
            ->andFilterWhere(['like', 'browser_type', $this->browser_type])
            ->andFilterWhere(['like', 'post_link', $this->post_link]);
        $query->orderBy('id DESC');
        return $dataProvider;
    }
}
