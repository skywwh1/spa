<?php

namespace frontend\models;

use DateInterval;
use DateTime;
use DateTimeZone;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * MyCampaignLogDailySearch represents the model behind the search form about `frontend\models\MyCampaignLogDaily`.
 */
class MyCampaignLogDailySearch extends MyCampaignLogDaily
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign_id', 'channel_id', 'time', 'clicks', 'unique_clicks', 'installs'], 'safe'],
            [['time_format', 'daily_cap', 'timezone', 'start', 'end'], 'safe'],
            [['pay_out'], 'number'],
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
        $query = MyCampaignLogDaily::find();

        $query->alias('clh');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (!$this->validate()) {
            return $dataProvider;
        }
//        var_dump(strtotime($this->start . '-1 day'));
//        var_dump(strtotime($this->end . '+1 day'));
        $start = new DateTime($this->start, new DateTimeZone($this->timezone));
        $end = new DateTime($this->end, new DateTimeZone($this->timezone));
        $start = $start->sub(new DateInterval('P1D'));
        $end = $end->add(new DateInterval('P1D'));
        $start = $start->getTimestamp();
        $end = $end->getTimestamp();
        $query->select([
            'cam.campaign_name campaign_name',
            'clh.campaign_id',
            'clh.channel_id',
            'clh.time',
            'clh.time_format',
            'clh.clicks',
            'clh.unique_clicks',
            'clh.installs',
            'clh.match_installs',
            'clh.pay_out',
            'clh.adv_price',
            'clh.daily_cap',
//            'campaign_name',

        ]);
        $query->joinWith('campaign cam');
        // grid filtering conditions
        $query->andFilterWhere([
            'campaign_id' => $this->campaign_id,
            'channel_id' => Yii::$app->user->getId(),
            'pay_out' => $this->pay_out,
        ]);

        $query->andFilterWhere(['like', 'time_format', $this->time_format])
            ->andFilterWhere(['like', 'cam.campaign_name', $this->campaign_name])
            ->andFilterWhere(['>', 'time', $start])
            ->andFilterWhere(['<', 'time', $end]);
        $query->orderBy(['time' => SORT_DESC, 'cam.campaign_name' => SORT_ASC]);
        return $dataProvider;
    }
}
