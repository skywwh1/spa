<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ApplyCampaign;

/**
 * ApplyCampaignSearch represents the model behind the search form about `common\models\ApplyCampaign`.
 */
class ApplyCampaignSearch extends ApplyCampaign
{
    public function attributes(){
        return array_merge(parent::attributes(),['channelName','campaignName','om']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign_id', 'channel_id', 'status', 'create_time'], 'integer'],
            [['channelName','campaignName','om'], 'safe'],
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
        $query = ApplyCampaign::find();

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
            'apply_campaign.status' => $this->status,
            'create_time' => $this->create_time,
        ]);

        $query->join('INNER JOIN','channel','apply_campaign.channel_id = channel.id');
        $query->andFilterWhere(['like','channel.username',$this->channelName]);
        $query->join('INNER JOIN','user','channel.om = user.id');
        $query->andFilterWhere(['like','user.username',$this->om]);

        $query->join('INNER JOIN','campaign','apply_campaign.campaign_id = campaign.id');
        $query->andFilterWhere(['like','campaign.campaign_name',$this->campaignName]);

        $query->orderBy('create_time DESC');

        return $dataProvider;
    }
}
