<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\LogFeed;

/**
 * LogFeedSearch represents the model behind the search form about `common\models\LogFeed`.
 */
class LogFeedSearch extends LogFeed
{


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'channel_id', 'campaign_id', 'feed_time', 'is_post', 'create_time','bd','om','pm'], 'safe'],
            [['auth_token', 'click_uuid', 'click_id', 'ch_subid', 'all_parameters', 'ip', 'campaign_uuid', 'advertiser_name','campaign_name'], 'safe'],
            [['adv_price'], 'number'],
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
        $query = LogFeed::find();
        $query->alias('feed');

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
        $query->select(['feed.*', 'adv.username advertiser_name','ca.campaign_name campaign_name','u3.username om', 'u.username bd','u2.username pm']);
        $query->joinWith('channel ch');
        $query->joinWith('campaign ca');
        $query->leftJoin('advertiser adv', 'ca.advertiser = adv.id');
        $query->leftJoin('user u', 'adv.bd = u.id');
        $query->leftJoin('user u2', 'adv.pm = u2.id');
        $query->leftJoin('user u3', 'ch.om = u3.id');

        // grid filtering conditions
        $query->andFilterWhere([
            'feed.id' => $this->id,
//            'feed.channel_id' => $this->channel_id,
            'feed.campaign_id' => $this->campaign_id,
            'feed.adv_price' => $this->adv_price,
            'feed.feed_time' => $this->feed_time,
            'feed.is_post' => $this->is_post,
            'feed.create_time' => $this->create_time,
        ]);

        $query->andFilterWhere(['like', 'feed.auth_token', $this->auth_token])
            ->andFilterWhere(['like', 'feed.click_uuid', $this->click_uuid])
            ->andFilterWhere(['like', 'feed.click_id', $this->click_id])
            ->andFilterWhere(['like', 'feed.ch_subid', $this->ch_subid])
            ->andFilterWhere(['like', 'ca.campaign_name', $this->campaign_name])
            ->andFilterWhere(['like', 'ca.campaign_uuid', $this->campaign_uuid])
            ->andFilterWhere(['like', 'ch.username', $this->channel_id])
            ->andFilterWhere(['like', 'feed.all_parameters', $this->all_parameters])
            ->andFilterWhere(['like', 'adv.username', $this->advertiser_name])
            ->andFilterWhere(['like', 'u.username', $this->bd])
            ->andFilterWhere(['like', 'u2.username', $this->pm])
            ->andFilterWhere(['like', 'u3.username', $this->om])
            ->andFilterWhere(['like', 'feed.ip', $this->ip]);

        if (\Yii::$app->user->can('admin')) {

        } else {
            if (\Yii::$app->user->can('pm')) {
                $query->andFilterWhere(['adv.pm' => \Yii::$app->user->id]);
            }else if (\Yii::$app->user->can('om')) {
                $query->andFilterWhere(['ch.om' => \Yii::$app->user->id]);
            } else if (\Yii::$app->user->can('bd')){
                $query->andFilterWhere(['adv.bd' => \Yii::$app->user->id]);
            }
        }

        $query->orderBy('feed.feed_time desc');
        return $dataProvider;
    }
}
