<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LogEventHourly;

/**
 * EventReportSearch represents the model behind the search form about `common\models\LogEventHourly`.
 */
class EventReportSearch extends LogEventHourly
{
    public $type;
    public $start;
    public $end;
    public $time_zone;
    public $channel_name;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'campaign_id', 'channel_id', 'time', 'match_total', 'total', 'create_time'], 'integer'],
            [['event'], 'safe'],
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
        $query = LogEventHourly::find();

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
            'time' => $this->time,
            'match_total' => $this->match_total,
            'total' => $this->total,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'event', $this->event]);

        return $dataProvider;
    }
}
