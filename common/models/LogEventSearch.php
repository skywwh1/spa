<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LogEvent;

/**
 * LogEventSearch represents the model behind the search form about `common\models\LogEvent`.
 */
class LogEventSearch extends LogEvent
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'channel_id', 'create_time', 'update_time', 'ip_long'], 'integer'],
            [['click_uuid', 'auth_token', 'event_name', 'event_value', 'ip'], 'safe'],
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
        $query = LogEvent::find();

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
            'update_time' => $this->update_time,
            'ip_long' => $this->ip_long,
        ]);

        $query->andFilterWhere(['like', 'click_uuid', $this->click_uuid])
            ->andFilterWhere(['like', 'auth_token', $this->auth_token])
            ->andFilterWhere(['like', 'event_name', $this->event_name])
            ->andFilterWhere(['like', 'event_value', $this->event_value])
            ->andFilterWhere(['like', 'ip', $this->ip]);

        return $dataProvider;
    }
}
