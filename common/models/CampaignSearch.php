<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Campaign;

/**
 * CampaignSearch represents the model behind the search form about `common\models\Campaign`.
 */
class CampaignSearch extends Campaign
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'advertiser', 'pricing_mode', 'promote_start', 'promote_end', 'end_time', 'device', 'platform', 'daily_cap', 'open_cap', 'target_geo', 'icon', 'creative_type', 'recommended', 'indirect', 'cap', 'cvr', 'status', 'open_type', 'subid_status', 'track_way', 'third_party', 'track_link_domain', 'creator', 'create_time', 'update_time'], 'integer'],
            [['campaign_name', 'tag', 'campaign_uuid', 'traffice_source', 'note', 'preview_link', 'package_name', 'app_name', 'app_size', 'category', 'version', 'app_rate', 'description', 'creative_link', 'creative_description', 'carriers', 'conversion_flow', 'epc', 'adv_link', 'ip_blacklist'], 'safe'],
            [['adv_price', 'now_payout'], 'number'],
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
        $query = Campaign::find();

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
            'advertiser' => $this->advertiser,
            'pricing_mode' => $this->pricing_mode,
            'promote_start' => $this->promote_start,
            'promote_end' => $this->promote_end,
            'end_time' => $this->end_time,
            'device' => $this->device,
            'platform' => $this->platform,
            'daily_cap' => $this->daily_cap,
            'open_cap' => $this->open_cap,
            'adv_price' => $this->adv_price,
            'now_payout' => $this->now_payout,
            'target_geo' => $this->target_geo,
            'icon' => $this->icon,
            'creative_type' => $this->creative_type,
            'recommended' => $this->recommended,
            'indirect' => $this->indirect,
            'cap' => $this->cap,
            'cvr' => $this->cvr,
            'status' => $this->status,
            'open_type' => $this->open_type,
            'subid_status' => $this->subid_status,
            'track_way' => $this->track_way,
            'third_party' => $this->third_party,
            'track_link_domain' => $this->track_link_domain,
            'creator' => $this->creator,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'campaign_name', $this->campaign_name])
            ->andFilterWhere(['like', 'tag', $this->tag])
            ->andFilterWhere(['like', 'campaign_uuid', $this->campaign_uuid])
            ->andFilterWhere(['like', 'traffice_source', $this->traffice_source])
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'preview_link', $this->preview_link])
            ->andFilterWhere(['like', 'package_name', $this->package_name])
            ->andFilterWhere(['like', 'app_name', $this->app_name])
            ->andFilterWhere(['like', 'app_size', $this->app_size])
            ->andFilterWhere(['like', 'category', $this->category])
            ->andFilterWhere(['like', 'version', $this->version])
            ->andFilterWhere(['like', 'app_rate', $this->app_rate])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'creative_link', $this->creative_link])
            ->andFilterWhere(['like', 'creative_description', $this->creative_description])
            ->andFilterWhere(['like', 'carriers', $this->carriers])
            ->andFilterWhere(['like', 'conversion_flow', $this->conversion_flow])
            ->andFilterWhere(['like', 'epc', $this->epc])
            ->andFilterWhere(['like', 'adv_link', $this->adv_link])
            ->andFilterWhere(['like', 'ip_blacklist', $this->ip_blacklist]);

        return $dataProvider;
    }
}
