<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CampaignChannelLogSearch represents the model behind the search form about `frontend\models\CampaignChannelLog`.
 */
class CampaignChannelLogSearch extends CampaignChannelLog
{
    public $campaign_name;
    public $geo;
    public $platform;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign_id', 'channel_id',  'daily_cap', 'is_run', 'creator', 'create_time', 'update_time', 'click', 'unique_click', 'install', 'match_install', 'def'], 'integer'],
            [['campaign_uuid', 'track_url', 'note', 'campaign_name', 'geo', 'platform','pricing_mode',], 'safe'],
            [['adv_price', 'pay_out', 'actual_discount', 'discount', 'cvr', 'cost', 'match_cvr', 'revenue', 'deduction_percent', 'profit', 'margin'], 'number'],
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
        $query = CampaignChannelLog::find();
        $query->alias('cl');
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
        $query->joinWith('campaign c');

        // grid filtering conditions
        $query->andFilterWhere([
            'cl.campaign_id' => $this->campaign_id,
            'cl.channel_id' => Yii::$app->user->identity->getId(),
            'cl.adv_price' => $this->adv_price,
            'cl.pricing_mode' => $this->pricing_mode,
            'pay_out' => $this->pay_out,
            'cl.daily_cap' => $this->daily_cap,
            'actual_discount' => $this->actual_discount,
            'discount' => $this->discount,
            'cl.status' => 1,
            'c.status' => 1,
            'c.platform' => $this->platform,
            'is_run' => $this->is_run,
            'creator' => $this->creator,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'click' => $this->click,
            'unique_click' => $this->unique_click,
            'install' => $this->install,
            'cvr' => $this->cvr,
            'cost' => $this->cost,
            'match_install' => $this->match_install,
            'match_cvr' => $this->match_cvr,
            'revenue' => $this->revenue,
            'def' => $this->def,
            'deduction_percent' => $this->deduction_percent,
            'profit' => $this->profit,
            'margin' => $this->margin,
        ]);

        $query->andFilterWhere(['like', 'campaign_uuid', $this->campaign_uuid])
            ->andFilterWhere(['like', 'c.campaign_name', $this->campaign_name])
            ->andFilterWhere(['like', 'c.target_geo', $this->geo]);
//            ->andFilterWhere(['like', 'note', $this->note]);
        $query->orderBy('create_time Desc');
        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function searchAll($params)
    {
        $query = CampaignChannelLog::find();

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
            'adv_price' => $this->adv_price,
            'pricing_mode' => $this->pricing_mode,
            'pay_out' => $this->pay_out,
            'daily_cap' => $this->daily_cap,
            'actual_discount' => $this->actual_discount,
            'discount' => $this->discount,
            'is_run' => $this->is_run,
            'creator' => $this->creator,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'click' => $this->click,
            'unique_click' => $this->unique_click,
            'install' => $this->install,
            'cvr' => $this->cvr,
            'cost' => $this->cost,
            'match_install' => $this->match_install,
            'match_cvr' => $this->match_cvr,
            'revenue' => $this->revenue,
            'def' => $this->def,
            'deduction_percent' => $this->deduction_percent,
            'profit' => $this->profit,
            'margin' => $this->margin,
        ]);

        $query->andFilterWhere(['like', 'campaign_uuid', $this->campaign_uuid])
            ->andFilterWhere(['like', 'track_url', $this->track_url])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }
}
