<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Deliver;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\VarDumper;

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
    public $cvr0;
    public $unique_clicks;
    public $campaign_name;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pricing_mode', 'daily_cap', 'is_run', 'creator', 'create_time', 'update_time', 'click', 'unique_click', 'install', 'match_install', 'def'], 'integer'],
            [['campaign_name', 'cvr0', 'timezone', 'start_time', 'end_time', 'campaign_id', 'channel_id', 'campaign_uuid', 'track_url', 'note'], 'safe'],
            [['adv_price', 'pay_out', 'actual_discount', 'discount', 'cvr', 'cost', 'match_cvr', 'revenue', 'deduction_percent', 'profit', 'margin'], 'number'],
        ];
    }

    public function attributeLabels()
    {
        return ['cvr0' => 'CVR'];
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
     * @param String $type
     * @return ActiveDataProvider
     */
    public function search($params, $type)
    {
        $query = new Query();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);
        if (isset($this->timezone)) {
            date_default_timezone_set(ArrayHelper::getValue(timezone_identifiers_list(), $this->timezone));
        } else {
            date_default_timezone_set("Asia/Shanghai");
            $this->timezone = array_search("Asia/Shanghai", timezone_identifiers_list());
        }


        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        $time = 'FROM_UNIXTIME(	fc.click_time,	"%Y-%m-%d"	) time';
        if ($type === 'hourly') {
            $time = 'FROM_UNIXTIME(	fc.click_time,	"%Y-%m-%d %H:00"	) time';
        }
        $query->select([
            'COUNT(fc.id) clicks',
            'COUNT(ff.id) installs',
            'COUNT(ff.id)/COUNT(fc.id) cvr0',
            $time,
            'de.campaign_id',
            'cp.campaign_name campaign_name',
            'COUNT(DISTINCT(fc.ip)) unique_clicks',
            'fc.pay_out',
            'COUNT(ff.id)*de.pay_out revenue',
        ]);

        $query->from('campaign_channel_log de');
        $query->leftJoin('campaign cp', 'de.campaign_id = cp.id');
        $query->leftJoin('log_click fc', 'de.campaign_id = fc.campaign_id and de.channel_id = fc.channel_id');
        $query->leftJoin('log_post ff', 'fc.click_uuid = ff.click_uuid');
        $query->andFilterWhere(['de.channel_id' => Yii::$app->user->getId()]);
        if (isset($this->start_time)) {
            $this->start_time = strtotime($this->start_time);
            $query->andFilterWhere(['>=', 'fc.click_time', $this->start_time]);
        } else {
            $this->start_time = time();
        }
        if (isset($this->end_time)) {
            $this->end_time = strtotime($this->end_time . '+1 day');
            $query->andFilterWhere(['<', 'fc.click_time', $this->end_time]);
            $this->end_time = strtotime(date('Y-m-d', $this->end_time) . '-1 day');
        } else {
            $this->end_time = time();
        }
        $query->andFilterWhere(['de.campaign_id' => $this->campaign_id]);
        $query->andFilterWhere(['like', 'cp.campaign_name', $this->campaign_name]);
        if ($type === 'offers') {
            $query->groupBy(['de.campaign_id',

                'fc.pay_out']);

        } else {
            $query->groupBy('time');
        }
        $query->orderBy('time desc');
//        var_dump($query->createCommand()->sql);
//        die();
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
        return $this->search($params, 'offers');
    }
}
