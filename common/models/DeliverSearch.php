<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Deliver;

/**
 * DeliverSearch represents the model behind the search form about `common\models\Deliver`.
 */
class DeliverSearch extends Deliver
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign_id', 'channel_id', 'pricing_mode', 'daily_cap', 'is_run', 'creator', 'create_time', 'update_time'], 'integer'],
            [['pay_out', 'discount'], 'number'],
            [['track_url', 'note'], 'safe'],
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
        $query = Deliver::find();

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
            'campaign_id' => $this->campaign_id,
            'channel_id' => $this->channel_id,
            'pricing_mode' => $this->pricing_mode,
            'pay_out' => $this->pay_out,
            'daily_cap' => $this->daily_cap,
            'discount' => $this->discount,
            'is_run' => $this->is_run,
            'creator' => $this->creator,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'track_url', $this->track_url])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
