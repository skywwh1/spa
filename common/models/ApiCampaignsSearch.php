<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ApiCampaigns;

/**
 * ApiCampaignsSearch represents the model behind the search form about `common\models\ApiCampaigns`.
 */
class ApiCampaignsSearch extends ApiCampaigns
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'adv_id', 'create_time', 'update_time'], 'integer'],
            [['url', 'key', 'param', 'json_offers_param', 'adv_update_time', 'effective_time', 'adv_campaign_id', 'campaign_uuid', 'campaign_name', 'pricing_mode', 'promote_start', 'end_time', 'platform', 'daily_cap', 'adv_price', 'daily_budget', 'target_geo', 'adv_link', 'traffice_source', 'note', 'preview_link', 'icon', 'package_name', 'app_name', 'app_size', 'category', 'version', 'app_rate', 'description', 'creative_link', 'creative_type', 'creative_description', 'carriers', 'conversion_flow', 'status'], 'safe'],
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
        $query = ApiCampaigns::find();

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
            'adv_id' => $this->adv_id,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'url', $this->url])
            ->andFilterWhere(['like', 'key', $this->key])
            ->andFilterWhere(['like', 'param', $this->param])
            ->andFilterWhere(['like', 'json_offers_param', $this->json_offers_param])
            ->andFilterWhere(['like', 'adv_update_time', $this->adv_update_time])
            ->andFilterWhere(['like', 'effective_time', $this->effective_time])
            ->andFilterWhere(['like', 'adv_campaign_id', $this->adv_campaign_id])
            ->andFilterWhere(['like', 'campaign_uuid', $this->campaign_uuid])
            ->andFilterWhere(['like', 'campaign_name', $this->campaign_name])
            ->andFilterWhere(['like', 'pricing_mode', $this->pricing_mode])
            ->andFilterWhere(['like', 'promote_start', $this->promote_start])
            ->andFilterWhere(['like', 'end_time', $this->end_time])
            ->andFilterWhere(['like', 'platform', $this->platform])
            ->andFilterWhere(['like', 'daily_cap', $this->daily_cap])
            ->andFilterWhere(['like', 'adv_price', $this->adv_price])
            ->andFilterWhere(['like', 'daily_budget', $this->daily_budget])
            ->andFilterWhere(['like', 'target_geo', $this->target_geo])
            ->andFilterWhere(['like', 'adv_link', $this->adv_link])
            ->andFilterWhere(['like', 'traffice_source', $this->traffice_source])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'preview_link', $this->preview_link])
            ->andFilterWhere(['like', 'icon', $this->icon])
            ->andFilterWhere(['like', 'package_name', $this->package_name])
            ->andFilterWhere(['like', 'app_name', $this->app_name])
            ->andFilterWhere(['like', 'app_size', $this->app_size])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'version', $this->version])
            ->andFilterWhere(['like', 'app_rate', $this->app_rate])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'creative_link', $this->creative_link])
            ->andFilterWhere(['like', 'creative_type', $this->creative_type])
            ->andFilterWhere(['like', 'creative_description', $this->creative_description])
            ->andFilterWhere(['like', 'carriers', $this->carriers])
            ->andFilterWhere(['like', 'conversion_flow', $this->conversion_flow])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}
