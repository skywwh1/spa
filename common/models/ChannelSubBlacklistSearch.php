<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ChannelSubBlacklist;

/**
 * ChannelSubBlacklistSearch represents the model behind the search form about `common\models\ChannelSubBlacklist`.
 */
class ChannelSubBlacklistSearch extends ChannelSubBlacklist
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'channel_id', 'create_time'], 'integer'],
            [['channel_name','sub_channel', 'geo', 'os', 'category'], 'safe'],
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
        $query = ChannelSubBlacklist::find();
        $query->alias('cs');

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
            'cs.id' => $this->id,
            'channel_id' => $this->channel_id,
            'cs.create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'sub_channel', $this->sub_channel])
            ->andFilterWhere(['like', 'geo', $this->geo])
            ->andFilterWhere(['like', 'os', $this->os])
            ->andFilterWhere(['like', 'ch.username', $this->channel_name])
            ->andFilterWhere(['like', 'category', $this->category]);

        return $dataProvider;
    }
}
