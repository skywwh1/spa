<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\FinanceAdvertiserCampaignBillTerm;

/**
 * FinanceAdvertiserCampaignBillTermSearch represents the model behind the search form about `backend\models\FinanceAdvertiserCampaignBillTerm`.
 */
class FinanceAdvertiserCampaignBillTermSearch extends FinanceAdvertiserCampaignBillTerm
{
    public $channel_name;
    public $campaign_name;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bill_id', 'time_zone', 'daily_cap', 'cap','channel_name','campaign_name'], 'safe'],
            [['adv_id', 'campaign_id', 'start_time', 'end_time', 'clicks', 'unique_clicks', 'installs', 'match_installs', 'redirect_installs', 'redirect_match_installs', 'create_time', 'update_time'], 'integer'],
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
        $query = FinanceAdvertiserCampaignBillTerm::find();
        $query->alias("fab");
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
            'fab.*',
            'fp.id pending_id',
            'fp.revenue pending_revenue',
            'fp.cost pending_cost',
            'fd.deduction_cost',
            'fd.deduction_revenue',
            'c.username channel_name',
        ]);

        // grid filtering conditions
        $query->andFilterWhere([
            'fab.adv_id' => $this->adv_id,
            'fab.campaign_id' => $this->campaign_id,
            'fab.channel_id' => $this->channel_id,
            'fab.start_time' => $this->start_time,
            'fab.end_time' => $this->end_time,
            'fab.clicks' => $this->clicks,
            'fab.unique_clicks' => $this->unique_clicks,
            'fab.installs' => $this->installs,
            'fab.match_installs' => $this->match_installs,
            'fab.redirect_installs' => $this->redirect_installs,
            'fab.redirect_match_installs' => $this->redirect_match_installs,
            'fab.pay_out' => $this->pay_out,
            'fab.adv_price' => $this->adv_price,
            'fab.cost' => $this->cost,
            'fab.redirect_cost' => $this->redirect_cost,
            'fab.revenue' => $this->revenue,
            'fab.redirect_revenue' => $this->redirect_revenue,
            'fab.create_time' => $this->create_time,
            'fab.update_time' => $this->update_time,
        ]);

        $query->leftJoin("finance_pending fp",'fp.adv_bill_id = fab.bill_id and fp.campaign_id = fab.campaign_id');
        $query->leftJoin("finance_deduction fd",'fd.adv_bill_id = fab.bill_id and fd.campaign_id = fab.campaign_id');
        $query->leftJoin("channel c",'c.id = fab.channel_id');
        $query->leftJoin("campaign camp",'camp.id = fab.campaign_id');

        $query->andFilterWhere(['like', 'bill_id', $this->bill_id])
            ->andFilterWhere(['like', 'fab.time_zone', $this->time_zone])
            ->andFilterWhere(['like', 'daily_cap', $this->daily_cap])
            ->andFilterWhere(['<>', 'fab.revenue', 0])
            ->andFilterWhere(['like', 'c.username', $this->channel_name])
            ->andFilterWhere(['like', 'camp.campaign_name', $this->campaign_name])
            ->andFilterWhere(['like', 'cap', $this->cap]);

        return $dataProvider;
    }
}
