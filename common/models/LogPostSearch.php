<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LogPost;

/**
 * LogPostSearch represents the model behind the search form about `common\models\LogPost`.
 */
class LogPostSearch extends LogPost
{

    public $campaign_name;
    public $channel_name;
    public $campaign_uuid;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'channel_id', 'campaign_id', 'daily_cap', 'post_time', 'post_status', 'create_time'], 'safe'],
            [['click_uuid', 'click_id', 'post_link','campaign_uuid'], 'safe'],
            [['pay_out', 'discount'], 'number'],
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
        $query = LogPost::find();
        $query->alias('post');

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

        $query->joinWith('channel ch');
        $query->joinWith('campaign ca');
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
//            'channel_id' => $this->channel_id,
//            'campaign_id' => $this->campaign_id,
            'pay_out' => $this->pay_out,
            'discount' => $this->discount,
            'daily_cap' => $this->daily_cap,
            'post_time' => $this->post_time,
            'post_status' => $this->post_status,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'click_uuid', $this->click_uuid])
            ->andFilterWhere(['like', 'click_id', $this->click_id])
            ->andFilterWhere(['like', 'ca.campaign_name', $this->campaign_id])
            ->andFilterWhere(['like', 'ca.campaign_uuid', $this->campaign_uuid])
            ->andFilterWhere(['like', 'ch.username', $this->channel_id])
            ->andFilterWhere(['like', 'post_link', $this->post_link]);

        return $dataProvider;
    }
}
