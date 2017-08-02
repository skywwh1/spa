<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ReportMatchInstallHourly;

/**
 * ReportMatchInstallHourlySearch represents the model behind the search form about `common\models\ReportMatchInstallHourly`.
 */
class ReportMatchInstallHourlySearch extends ReportMatchInstallHourly
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign_id', 'time', 'advertiser_id', 'installs', 'installs_in', 'update_time', 'create_time'], 'integer'],
            [['revenue'], 'number'],
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
        $query = ReportMatchInstallHourly::find();

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
            'time' => $this->time,
            'advertiser_id' => $this->advertiser_id,
            'installs' => $this->installs,
            'installs_in' => $this->installs_in,
            'revenue' => $this->revenue,
            'update_time' => $this->update_time,
            'create_time' => $this->create_time,
        ]);

        return $dataProvider;
    }
}
