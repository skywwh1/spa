<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ChannelSubWhitelist;

/**
 * ChannelSubWhitelistSearch represents the model behind the search form about `common\models\ChannelSubWhitelist`.
 */
class ChannelSubWhitelistSearch extends ChannelSubWhitelist
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'channel_id', 'create_time'], 'integer'],
            [['sub_channel', 'geo', 'os', 'category', 'note'], 'safe'],
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
        $query = ChannelSubWhitelist::find();

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
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'sub_channel', $this->sub_channel])
            ->andFilterWhere(['like', 'geo', $this->geo])
            ->andFilterWhere(['like', 'os', $this->os])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
