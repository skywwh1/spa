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

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'channel_id', 'campaign_id', 'daily_cap', 'post_time', 'post_status', 'create_time'], 'safe'],
            [['click_uuid', 'click_id', 'post_link', 'campaign_uuid', 'advertiser_name', 'campaign_name'], 'safe'],
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
        $query->select(['post.*', 'adv.username advertiser_name', 'ca.campaign_name campaign_name']);
        $query->joinWith('channel ch');
        $query->joinWith('campaign ca');
        $query->leftJoin('advertiser adv', 'ca.advertiser = adv.id');
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
//            'channel_id' => $this->channel_id,
            'campaign_id' => $this->campaign_id,
            'pay_out' => $this->pay_out,
            'discount' => $this->discount,
            'daily_cap' => $this->daily_cap,
            'post_time' => $this->post_time,
            'post_status' => $this->post_status,
            'create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'click_uuid', $this->click_uuid])
            ->andFilterWhere(['like', 'click_id', $this->click_id])
            ->andFilterWhere(['like', 'ca.campaign_name', $this->campaign_name])
            ->andFilterWhere(['like', 'ca.campaign_uuid', $this->campaign_uuid])
            ->andFilterWhere(['like', 'ch.username', $this->channel_id])
            ->andFilterWhere(['like', 'adv.username', $this->advertiser_name])
            ->andFilterWhere(['like', 'post_link', $this->post_link]);
        $query->orderBy('post.create_time desc');
//        var_dump($query->createCommand()->sql);
//        die();
        return $dataProvider;
    }
}
