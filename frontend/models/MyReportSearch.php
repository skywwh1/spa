<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Deliver;

/**
 * MyReportSearch represents the model behind the search form about `common\models\Deliver`.
 */
class MyReportSearch extends Deliver
{
    public $time;
    public $clicks;
    public $start_time;
    public $end_time;
    public $timezone;
    public $installs;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pricing_mode', 'daily_cap', 'is_run', 'creator', 'create_time', 'update_time', 'click', 'unique_click', 'install', 'match_install', 'def'], 'integer'],
            [['timezone', 'start_time', 'end_time', 'campaign_id', 'channel_id', 'campaign_uuid', 'track_url', 'note'], 'safe'],
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
    public function search($params, $type)
    {
        $query = MyReportSearch::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        //date_default_timezone_set('Europe/London');

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $time = 'FROM_UNIXTIME(	fc.create_time,	"%Y-%m-%d"	) time';
        if ($type === 'hourly') {
            $time = 'FROM_UNIXTIME(	fc.create_time,	"%Y-%m-%d %H"	) time';
        }
        $query->select([
            'COUNT(fc.id) clicks',
            'COUNT(ff.id) installs',
            $time,
            'de.*']);

        $query->from('campaign_channel_log de');
        $query->leftJoin('feedback_channel_click_log fc', 'de.campaign_uuid = fc.cp_uid');
        $query->leftJoin('feedback_advertiser_feed_log ff', 'fc.click_uuid = ff.click_id');
        if (isset($this->start_time)){
            $this->start_time=strtotime($this->start_time);
            $query->andFilterWhere(['>=', 'fc.create_time', $this->start_time]);
        }
        if(isset($this->end_time)){
            $this->end_time=strtotime($this->end_time. ' +1 day');
            $query->andFilterWhere(['<', 'fc.create_time', $this->end_time]);
        }
        $query->groupBy('time');
        $query->orderBy('clicks');


        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function hourlySearch($params)
    {
        return $this->search($params, 'hourly');
    }

    public function dailySearch($params)
    {
        return $this->search($params, 'daily');
    }

    public function offersSearch($params)
    {
        $query = Deliver::find();

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
            'channel_id' => $this->channel_id,
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
