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
    public $campaign_name;
    public $channel_name;
    public $creator_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'campaign_id', 'channel_id', 'is_send', 'is_effected', 'effect_time', 'create_time', 'creator'], 'integer'],
            [['sub_channel', 'name','campaign_name','channel_name'], 'safe'],
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
        $query->alias("csr");
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

        $query->join('INNER JOIN','channel','csr.channel_id = channel.id');
        $query->andFilterWhere(['like','channel.username',$this->channel_name]);
        $query->join('left JOIN','campaign b','csr.campaign_id = b.id');

        if ($this->campaign_name) {
            $query->andFilterWhere(['like','b.campaign_name',trim($this->campaign_name)]);
        }
        $query->andFilterWhere(['like','sub_channel',$this->sub_channel]);
        $query->andFilterWhere(['like', 'name', $this->name]);

        return $dataProvider;
    }
}
