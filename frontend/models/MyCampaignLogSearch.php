<?php

namespace frontend\models;

use DateInterval;
use DateTime;
use DateTimeZone;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MyCampaignLogHourlySearch represents the model behind the search form about `frontend\models\MyCampaignLogHourly`.
 */
class MyCampaignLogSearch extends MyCampaignLogHourly
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign_id', 'channel_id', 'time', 'clicks', 'unique_clicks', 'installs'], 'safe'],
            [['time_format', 'daily_cap', 'timezone', 'start', 'end'], 'safe'],
            [['pay_out', 'adv_price'], 'number'],
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
        $query = MyCampaignLogHourly::find();

        $query->alias('clh');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
//        $a = strtotime($this->start);
        $start = new DateTime($this->start, new DateTimeZone($this->timezone));
        $end = new DateTime($this->end, new DateTimeZone($this->timezone));
        $end = $end->add(new DateInterval('P1D'));
        $start = $start->getTimestamp();
        $end = $end->getTimestamp();
        $query->select([
            'cam.campaign_name campaign_name',
            'clh.campaign_id',
            'sum(clh.clicks) clicks',
            'sum(clh.unique_clicks) unique_clicks',
            'sum(clh.installs) installs',
            'avg(clh.pay_out) pay_out',

        ]);
        $query->joinWith('campaign cam');
        // grid filtering conditions
        $query->andFilterWhere([
            'campaign_id' => $this->campaign_id,
            'channel_id' => Yii::$app->user->getId(),
            'pay_out' => $this->pay_out,
        ]);

        $query->andFilterWhere(['like', 'cam.campaign_name', $this->campaign_name])
            ->andFilterWhere(['>=', 'time', $start])
            ->andFilterWhere(['<', 'time', $end]);
        $query->groupBy(['clh.campaign_id']);
        $query->orderBy(['time' => SORT_DESC, 'cam.campaign_name' => SORT_ASC,]);
        return $dataProvider;
    }
}
