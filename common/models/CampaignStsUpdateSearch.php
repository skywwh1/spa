<?php

namespace common\models;

use common\utility\MailUtil;
use common\utility\TimeZoneUtil;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CampaignStsUpdate;
use yii\db\Query;

/**
 * CampaignStsUpdateSearch represents the model behind the search form about `common\models\CampaignStsUpdate`.
 */
class CampaignStsUpdateSearch extends CampaignStsUpdate
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'campaign_id', 'channel_id', 'type', 'is_send', 'send_time', 'is_effected',], 'integer'],
            [['name', 'value','effect_time','create_time','campaign_name','channel_name'], 'safe'],
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
        $query = CampaignStsUpdate::find();
        $query->alias('csu');
//        $query = new Query();
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' =>[
                'attributes' => [
                    'effect_time' => [
                        'asc' => ['effect_time' => SORT_ASC],
                        'desc' => ['effect_time' => SORT_DESC],
                    ],
                    'csu.create_time' => [
                        'asc' => ['create_time' => SORT_ASC],
                        'desc' => ['create_time' => SORT_DESC],
                    ],
                    'campaign_id' => [
                        'asc' => ['campaign_id' => SORT_ASC],
                        'desc' => ['campaign_id' => SORT_DESC],
                    ],
                    'channel_id' => [
                        'asc' => ['channel_id' => SORT_ASC],
                        'desc' => ['channel_id' => SORT_DESC],
                    ],
                    'value' => [
                        'asc' => ['value' => SORT_ASC],
                        'desc' => ['value' => SORT_DESC],
                    ],
                    'old_value' => [
                        'asc' => ['old_value' => SORT_ASC],
                        'desc' => ['old_value' => SORT_DESC],
                    ],
                ],
            ]
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->Select([
            'csu.id',
            'campaign_id',
            'channel_id',
            'name',
            'value',
            'old_value',
            'csu.type',
            'is_effected',
            'effect_time',
            'csu.create_time',
            'ch.username channel_name',
            'cam.campaign_name campaign_name',
            ]);

        $query->leftJoin('channel ch', 'csu.channel_id = ch.id');
        $query->leftJoin('campaign cam', 'csu.campaign_id = cam.id');

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'campaign_id' => $this->campaign_id,
            'channel_id' => $this->channel_id,
            'type' => $this->type,
            'is_send' => $this->is_send,
            'send_time' => $this->send_time,
            'is_effected' => $this->is_effected,
            'effect_time' => $this->effect_time,
            'create_time' => $this->create_time,
            'name' => 'payout',
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'ch.username', $this->channel_name])
            ->andFilterWhere(['like', 'cam.campaign_name', $this->campaign_name]);

        if ($dataProvider->getSort()->getOrders()==null){
            $query->orderBy(["effect_time" => SORT_DESC]);
        }
        return $dataProvider;
    }

    /**
     * @return ActiveDataProvider
     */
    public function campaignUpdateSearch()
    {
        $query = CampaignStsUpdate::find();
        $query->alias('csu');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $query->Select([
            'csu.id',
            'campaign_id',
            'cam.campaign_name campaign_name',
            'name',
            'value',
            'old_value',
            'csu.type',
            'is_effected',
            'effect_time',
            'csu.create_time',
            'u.username creator_name',
        ]);

        $query->leftJoin('channel ch', 'csu.channel_id = ch.id');
        $query->leftJoin('campaign cam', 'csu.campaign_id = cam.id');
        $query->leftJoin('user u', 'csu.creator = u.id');
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'campaign_id' => $this->campaign_id,
            'channel_id' => $this->channel_id,
            'csu.type' => $this->type,
            'is_send' => $this->is_send,
            'send_time' => $this->send_time,
            'is_effected' => $this->is_effected,
            'effect_time' => $this->effect_time,
            'name' => $this->name
        ]);

        if (empty($this->type)){
//            $beginThisDay = TimeZoneUtil::setTimeZoneGMT8Before();
//            $query->andFilterWhere(['>', 'csu.create_time', $beginThisDay]);
            $query->andFilterWhere(['is_read' => 0]);
        }
        $query->andFilterWhere(['like', 'value', $this->value])
            ->andFilterWhere(['like', 'ch.username', $this->channel_name])
            ->andFilterWhere(['like', 'cam.campaign_name', $this->campaign_name]);


        if ($dataProvider->getSort()->getOrders()==null){
            $query->orderBy(["effect_time" => SORT_DESC]);
        }
//        var_dump($query->createCommand()->sql);
//        var_dump($beginThisDay);
//        var_dump($this->channel_name);
//        die();
        return $dataProvider;
    }
}
