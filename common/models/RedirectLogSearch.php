<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\RedirectLog;

/**
 * RedirectLogSearch represents the model behind the search form about `common\models\RedirectLog`.
 */
class RedirectLogSearch extends RedirectLog
{
    public function attributes(){
        return array_merge(parent::attributes(),['channelName','campaignName','redirectCampaignName']);
    }
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'campaign_id', 'channel_id', 'campaign_id_new', 'discount_numerator', 'discount_denominator', 'status', 'end_time', 'create_time', 'update_time', 'creator'], 'integer'],
            [['daily_cap','channelName','campaignName','redirectCampaignName'], 'safe'],
            [['actual_discount', 'discount'], 'number'],
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
        $query = RedirectLog::find();

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
        $filters = [
            'campaign_channel_log_redirect.id' => $this->id,
            'campaign_id' => $this->campaign_id,
            'channel_id' => $this->channel_id,
            'campaign_id_new' => $this->campaign_id_new,
            'actual_discount' => $this->actual_discount,
            'discount' => $this->discount,
            'discount_numerator' => $this->discount_numerator,
            'discount_denominator' => $this->discount_denominator,
            'end_time' => $this->end_time,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
            'creator' => $this->creator,
        ];
        if (isset($this->status)) {
            $filters['campaign_channel_log_redirect.status'] = $this->status;
        } else {
            $filters['campaign_channel_log_redirect.status'] = 1;
        }
        $query->andFilterWhere($filters);
        $query->andFilterWhere(['like', 'daily_cap', $this->daily_cap]);

        $query->join('INNER JOIN','channel','campaign_channel_log_redirect.channel_id = channel.id');
        $query->andFilterWhere(['like','channel.username',$this->channelName]);
        $query->join('left JOIN','campaign b','campaign_channel_log_redirect.campaign_id = b.id');
        $query->join('left JOIN','campaign c','campaign_channel_log_redirect.campaign_id_new = c.id');

        if ($this->campaignName) {
            $query->andFilterWhere(['like','b.campaign_name',trim($this->campaignName)]);
        }
        if ($this->redirectCampaignName){
            $query->andFilterWhere(['like','c.campaign_name',trim($this->redirectCampaignName)]);
        }

        $query->orderBy('create_time desc');

        return $dataProvider;
    }
}
