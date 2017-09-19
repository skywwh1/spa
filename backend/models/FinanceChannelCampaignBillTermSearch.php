<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\FinanceChannelCampaignBillTerm;

/**
 * FinanceChannelCampaignBillTermSearch represents the model behind the search form about `backend\models\FinanceChannelCampaignBillTerm`.
 */
class FinanceChannelCampaignBillTermSearch extends FinanceChannelCampaignBillTerm
{
    public $campaign_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bill_id', 'time_zone', 'daily_cap', 'cap', 'note','campaign_name'], 'safe'],
            [['channel_id', 'campaign_id', 'start_time', 'end_time', 'clicks', 'unique_clicks', 'installs', 'match_installs', 'redirect_installs', 'redirect_match_installs', 'create_time', 'update_time'], 'integer'],
            [['pay_out', 'adv_price', 'cost', 'redirect_cost', 'revenue', 'redirect_revenue'], 'number'],
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
        $query = FinanceChannelCampaignBillTerm::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'channel_id' => $this->channel_id,
            'campaign_id' => $this->campaign_id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'clicks' => $this->clicks,
            'unique_clicks' => $this->unique_clicks,
            'installs' => $this->installs,
            'match_installs' => $this->match_installs,
            'redirect_installs' => $this->redirect_installs,
            'redirect_match_installs' => $this->redirect_match_installs,
            'pay_out' => $this->pay_out,
            'adv_price' => $this->adv_price,
            'cost' => $this->cost,
            'redirect_cost' => $this->redirect_cost,
            'revenue' => $this->revenue,
            'redirect_revenue' => $this->redirect_revenue,
            'create_time' => $this->create_time,
            'update_time' => $this->update_time,
        ]);

        $query->andFilterWhere(['like', 'bill_id', $this->bill_id])
            ->andFilterWhere(['like', 'time_zone', $this->time_zone])
            ->andFilterWhere(['like', 'daily_cap', $this->daily_cap])
            ->andFilterWhere(['<>', 'cost', 0])
            ->andFilterWhere(['like', 'note', $this->note]);

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function financeChannelSearch($params)
    {
        $query = FinanceChannelCampaignBillTerm::find();
        $query->alias("fcb");
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => false,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->select([
            'fcb.*',
            'fp.id pending_id',
            'fp.revenue pending_revenue',
            'fp.cost pending_cost',
            'fd.deduction_cost',
            'fd.deduction_revenue',
        ]);

        // grid filtering conditions
        $query->andFilterWhere([
            'fcb.channel_id' => $this->channel_id,
            'fcb.campaign_id' => $this->campaign_id,
            'fcb.start_time' => $this->start_time,
            'fcb.end_time' => $this->end_time,
            'fcb.clicks' => $this->clicks,
            'fcb.unique_clicks' => $this->unique_clicks,
            'fcb.installs' => $this->installs,
            'fcb.match_installs' => $this->match_installs,
            'fcb.redirect_installs' => $this->redirect_installs,
            'fcb.redirect_match_installs' => $this->redirect_match_installs,
            'fcb.pay_out' => $this->pay_out,
            'fcb.adv_price' => $this->adv_price,
            'fcb.cost' => $this->cost,
            'fcb.redirect_cost' => $this->redirect_cost,
            'fcb.revenue' => $this->revenue,
            'fcb.redirect_revenue' => $this->redirect_revenue,
            'fcb.create_time' => $this->create_time,
            'fcb.update_time' => $this->update_time,
        ]);

        // grid filtering conditions
        $query->andFilterWhere([
            'bill_id'=> $this->bill_id,
//             'fp.status' => 0
        ]);

        $query->leftJoin("finance_pending fp",'fp.channel_bill_id = fcb.bill_id and fp.campaign_id = fcb.campaign_id');
        $query->leftJoin("finance_deduction fd",'fd.channel_bill_id = fcb.bill_id and fd.campaign_id = fcb.campaign_id');
        $query->leftJoin("campaign camp",'camp.id = fcb.campaign_id');

        $query->andFilterWhere(['like', 'fcb.time_zone', $this->time_zone])
            ->andFilterWhere(['like', 'camp.campaign_name', $this->campaign_name])
            ->andFilterWhere(['<>', 'fcb.cost', 0]);

//        var_dump($query->createCommand()->sql);
//        die();
        return $dataProvider;
    }
}
