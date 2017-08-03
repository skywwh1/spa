<?php

namespace backend\models;

use common\models\Channel;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\FinanceCompensation;
use DateTime;
use DateTimeZone;
use DateInterval;
/**
 * FinanceCompensationSearch represents the model behind the search form about `backend\models\FinanceCompensation`.
 */
class FinanceCompensationSearch extends FinanceCompensation
{
    public $deduction_ids;
    public $adv_name;
    public $master_channel;
    public $bd;
    public $om;
    public $pm;
    public $time_zone;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['deduction_id', 'status', 'editor', 'creator'], 'integer'],
            [['adv_name','master_channel','bd','om','pm','start_date','end_date','channel','campaign_id','status','deduction_id',], 'safe'],
            [['compensation', 'billable_cost', 'billable_revenue', 'billable_margin', 'final_margin'], 'number'],
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
        $query = FinanceCompensation::find();
        $query->alias('fc');

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
        $query->joinWith('deduction d');
        if (!empty($this->channel)){
            $channel_id =  Channel::findByUsername($this->channel)->id;
            $query->andFilterWhere([ 'd.channel_id' => $channel_id ]);
        }
        if (!empty($this->master_channel)){
            $channel_id =  Channel::findByUsername($this->master_channel)->id;
            $query->andFilterWhere([ 'd.channel_id' => $channel_id ]);
        }

        $start = new DateTime($this->start_date, new DateTimeZone($this->time_zone));
        $end = new DateTime($this->end_date, new DateTimeZone($this->time_zone));
        $start_date = $start->getTimestamp();
        $end_date = $end->add(new DateInterval('P1D'));
        $end_date = $end_date->getTimestamp();
        // grid filtering conditions
        $query->andFilterWhere([
            'deduction_id' => $this->deduction_id,
            'compensation' => $this->compensation,
            'billable_cost' => $this->billable_cost,
            'billable_revenue' => $this->billable_revenue,
            'billable_margin' => $this->billable_margin,
            'final_margin' => $this->final_margin,
            'fc.status' => $this->status,
            'editor' => $this->editor,
            'creator' => $this->creator,
            'd.adv' => $this->adv_name,
            'd.pm' => $this->pm,
            'd.om' => $this->om,
            'd.bd' => $this->bd,
            'd.campaign_id' => $this->campaign_id,
        ]);
        $query->andFilterWhere(['>=', 'd.start_date', $start_date])
         ->andFilterWhere(['<', 'd.end_date', $end_date]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function detailSearch($params)
    {
        $query = FinanceCompensation::find();

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
        $query->where([
            'in', 'deduction_id', $this->deduction_ids
        ]);

        return $dataProvider;
    }
}
