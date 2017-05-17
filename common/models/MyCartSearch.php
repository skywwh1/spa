<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\MyCart;

/**
 * MyCartSearch represents the model behind the search form about `common\models\MyCart`.
 */
class MyCartSearch extends MyCart
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'campaign_id', 'tag', 'direct', 'advertiser'], 'integer'],
            [['campaign_name', 'target_geo', 'platform', 'payout', 'daily_cap', 'traffic_source','preview_link'], 'safe'],
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
        $query = MyCart::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
//            'pagination' => [
//                'defaultPageSize' => 5,
//            ]
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
            'tag' => $this->tag,
            'direct' => $this->direct,
            'advertiser' => $this->advertiser,
        ]);

        $query->andFilterWhere(['like', 'campaign_name', $this->campaign_name])
            ->andFilterWhere(['like', 'target_geo', $this->target_geo])
            ->andFilterWhere(['like', 'platform', $this->platform])
            ->andFilterWhere(['like', 'payout', $this->payout])
            ->andFilterWhere(['like', 'daily_cap', $this->daily_cap])
            ->andFilterWhere(['like', 'traffic_source', $this->traffic_source]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function showSelectCampaign($keys)
    {
        $query = MyCart::find();

        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $query->andFilterWhere(['in', 'id', $keys]);

        return $dataProvider;
    }
}
