<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ChannelBlack;
use yii\db\Query;

/**
 * ChannelBlackSearch represents the model behind the search form about `common\models\ChannelBlack`.
 */
class ChannelBlackSearch extends ChannelBlack
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'advertiser', 'channel_id', 'action_type'], 'integer'],
            [['id', 'channel_id', 'action_type','channel_name','advertiser','geo','os','advertiser_name',], 'safe'],
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
//        $query = ChannelBlack::find();
//
//        // add conditions that should always apply here
//
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//        ]);
//
//        $this->load($params);
//
//        if (!$this->validate()) {
//            // uncomment the following line if you do not want to return any records when validation fails
//            // $query->where('0=1');
//            return $dataProvider;
//        }
//
//        // grid filtering conditions
//        $query->andFilterWhere([
//            'id' => $this->id,
//            'advertiser' => $this->advertiser,
//            'channel_id' => $this->channel_id,
//            'campaign_id' => $this->campaign_id,
//            'action' => $this->action,
//        ]);
//
//        $query->andFilterWhere(['like', 'geo', $this->geo])
//            ->andFilterWhere(['like', 'os', $this->os])
//            ->andFilterWhere(['like', 'note', $this->note]);
//        $query = new Query();
        $query = ChannelBlack::find();
//        $query->alias('csu');
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $this->load($params);

        $query->select([
            'ch.username channel_name',
            'adv.username advertiser_name',
            'cb.channel_id',
            'cb.id',
            'cb.geo',
            'cb.os',
            'cb.action_type',
            'cb.note',
        ]);

        $query->from('channel_black cb');
        $query->leftJoin('channel ch', 'cb.channel_id = ch.id');
        $query->leftJoin('advertiser adv', 'cb.advertiser = adv.id');

        // grid filtering conditions
        $query->andFilterWhere([
            'cb.id' => $this->id,
            'channel_id' => $this->channel_id,
            'action_type' => $this->action_type,
        ]);

        $query->andFilterWhere(['like', 'ch.username', $this->channel_name])
            ->andFilterWhere(['like', 'adv.username', $this->advertiser_name]);

        if ($dataProvider->getSort()->getOrders()==null){
            $query->orderBy(['ch.username' => SORT_ASC]);
        }

        return $dataProvider;
    }
}
