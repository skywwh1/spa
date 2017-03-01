<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Deliver;

/**
 * ReportSearch represents the model behind the search form about `common\models\Deliver`.
 */
class ReportSearch extends Deliver
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['pricing_mode', 'daily_cap', 'is_run', 'creator', 'create_time', 'update_time', 'click', 'unique_click', 'install', 'match_install', 'def'], 'integer'],
            [['campaign_id', 'channel_id', 'campaign_uuid', 'track_url', 'note'], 'safe'],
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
    public function search($params)
    {
        $query = Deliver::find();
        $query->alias('de');
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
        $query->select([
            'de.campaign_id',
            'de.channel_id',
            'de.campaign_uuid',
            'de.adv_price',
            'de.pricing_mode',
            'de.pay_out',
            'de.daily_cap',
            'de.actual_discount',
            'de.discount',
            'de.discount_numerator',
            'de.discount_denominator',
            'de.is_run',
            'de.status',
            'de.end_time',
            'de.creator',
            'de.create_time',
            'de.update_time',
            'de.track_url',
            'count(fc.id) click',
            'de.unique_click',
            'de.install',
            'de.cvr',
            'de.cost',
            'de.match_install',
            'de.match_cvr',
            'de.revenue',
            'de.def',
            'de.deduction_percent',
            'de.profit',
            'de.margin',
            'de.note',
            'FROM_UNIXTIME(fc.click_time, "%Y-%m-%d") time',
        ]);
        $query->joinWith('campaign ca');
        $query->joinWith('channel ch');
        $query->leftJoin('log_click fc', 'de.campaign_id = fc.campaign_id AND de.channel_id = fc.channel_id');
        // grid filtering conditions
        $query->andFilterWhere([
            'daily_cap' => $this->daily_cap,
            'actual_discount' => $this->actual_discount,
            'discount' => $this->discount,
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
            ->andFilterWhere(['like', 'note', $this->note])
            ->andFilterWhere(['like', 'ca.campaign_name', $this->campaign_id])
            ->andFilterWhere(['like', 'ch.username', $this->channel_id]);
        $query->groupBy('time');
        $query->orderBy(['click' => SORT_DESC, 'de.update_time' => SORT_DESC]);

        return $dataProvider;
    }
}
