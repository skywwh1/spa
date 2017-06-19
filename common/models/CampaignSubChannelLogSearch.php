<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CampaignSubChannelLog;

/**
 * CampaignSubChannelLogSearch represents the model behind the search form about `common\models\CampaignSubChannelLog`.
 */
class CampaignSubChannelLogSearch extends CampaignSubChannelLog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'campaign_id', 'channel_id', 'is_send', 'is_effected', 'effect_time', 'create_time', 'creator'], 'integer'],
            [['sub_channel', 'name'], 'safe'],
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
        $query = CampaignSubChannelLog::find();

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
            'campaign_id' => $this->campaign_id,
            'channel_id' => $this->channel_id,
            'is_send' => $this->is_send,
            'is_effected' => $this->is_effected,
            'effect_time' => $this->effect_time,
            'create_time' => $this->create_time,
            'creator' => $this->creator,
        ]);

        $query->andFilterWhere(['like', 'sub_channel', $this->sub_channel])
            ->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
