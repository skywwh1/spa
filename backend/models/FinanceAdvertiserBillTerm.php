<?php

namespace backend\models;

use common\models\Advertiser;
use common\models\Campaign;
use Yii;

/**
 * This is the model class for table "finance_advertiser_bill_term".
 *
 * @property string $bill_id
 * @property string $invoice_id
 * @property string $period
 * @property integer $adv_id
 * @property string $time_zone
 * @property integer $start_time
 * @property integer $end_time
 * @property integer $clicks
 * @property integer $unique_clicks
 * @property integer $installs
 * @property integer $match_installs
 * @property integer $redirect_installs
 * @property integer $redirect_match_installs
 * @property string $pay_out
 * @property string $adv_price
 * @property string $daily_cap
 * @property string $cap
 * @property string $cost
 * @property string $redirect_cost
 * @property string $revenue
 * @property string $redirect_revenue
 * @property string $add_historic
 * @property string $pending
 * @property string $deduction
 * @property string $add_revenue
 * @property string $final_revenue
 * @property string $actual_margin
 * @property string $received_amount
 * @property string $receivable
 * @property string $prepayment
 * @property integer $status
 * @property string $note
 * @property string $adjust_revenue
 * @property string $adjust_note
 * @property integer $update_time
 * @property integer $create_time
 *
 * @property FinanceAddRevenue[] $financeAddRevenues
 * @property Advertiser $adv
 * @property FinanceAdvertiserCampaignBillTerm[] $financeAdvertiserCampaignBillTerms
 * @property Campaign[] $campaigns
 * @property FinanceAdvertiserPrepayment[] $financeAdvertiserPrepayments
 * @property FinanceDeduction[] $financeDeductions
 */
class FinanceAdvertiserBillTerm extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'finance_advertiser_bill_term';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bill_id', 'invoice_id', 'period', 'adv_id', 'start_time', 'end_time'], 'required'],
            [['adv_id', 'start_time', 'end_time', 'clicks', 'unique_clicks', 'installs', 'match_installs', 'redirect_installs', 'redirect_match_installs', 'status', 'update_time', 'create_time'], 'integer'],
            [['pay_out', 'adv_price', 'cost', 'redirect_cost', 'revenue', 'redirect_revenue', 'add_historic', 'pending', 'deduction', 'add_revenue', 'final_revenue', 'actual_margin', 'received_amount', 'receivable', 'prepayment','adjust_revenue'], 'number'],
            [['note','adjust_note'], 'string'],
            [['bill_id', 'period'], 'string', 'max' => 255],
            [['invoice_id', 'time_zone', 'daily_cap', 'cap'], 'string', 'max' => 100],
            [['invoice_id'], 'unique'],
            [['adv_id'], 'exist', 'skipOnError' => true, 'targetClass' => Advertiser::className(), 'targetAttribute' => ['adv_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'bill_id' => 'Bill ID',
            'invoice_id' => 'Invoice ID',
            'period' => 'Period',
            'adv_id' => 'Adv ID',
            'time_zone' => 'Time Zone',
            'start_time' => 'Start Time',
            'end_time' => 'End Time',
            'clicks' => 'Clicks',
            'unique_clicks' => 'Unique Clicks',
            'installs' => 'Installs',
            'match_installs' => 'Match Installs',
            'redirect_installs' => 'Redirect Installs',
            'redirect_match_installs' => 'Redirect Match Installs',
            'pay_out' => 'Pay Out',
            'adv_price' => 'Adv Price',
            'daily_cap' => 'Daily Cap',
            'cap' => 'Cap',
            'cost' => 'Cost',
            'redirect_cost' => 'Redirect Cost',
            'revenue' => 'Revenue',
            'redirect_revenue' => 'Redirect Revenue',
            'add_historic' => 'Add Historic',
            'pending' => 'Pending',
            'deduction' => 'Deduction',
            'add_revenue' => 'Add Revenue',
            'final_revenue' => 'Final Revenue',
            'actual_margin' => 'Actual Margin',
            'received_amount' => 'Received Amount',
            'receivable' => 'Receivable',
            'prepayment' => 'Prepayment',
            'status' => 'Status',
            'note' => 'Note',
            'adjust_revenue'=> 'Adjust Revenue',
            'adjust_note' => 'Adjust Note',
            'update_time' => 'Update Time',
            'create_time' => 'Create Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceAddRevenues()
    {
        return $this->hasMany(FinanceAddRevenue::className(), ['advertiser_bill_id' => 'bill_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdv()
    {
        return $this->hasOne(Advertiser::className(), ['id' => 'adv_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceAdvertiserCampaignBillTerms()
    {
        return $this->hasMany(FinanceAdvertiserCampaignBillTerm::className(), ['bill_id' => 'bill_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaigns()
    {
        return $this->hasMany(Campaign::className(), ['id' => 'campaign_id'])->viaTable('finance_advertiser_campaign_bill_term', ['bill_id' => 'bill_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceAdvertiserPrepayments()
    {
        return $this->hasMany(FinanceAdvertiserPrepayment::className(), ['advertiser_bill_id' => 'bill_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceDeductions()
    {
        return $this->hasMany(FinanceDeduction::className(), ['adv_bill_id' => 'bill_id']);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->create_time = time();
        } else {
            $this->update_time = time();
        }
        return parent::beforeSave($insert); //
    }

    public function getNumberConfirmSendMail(){
        $beginThisMonth=mktime(0,0,0,date('m'),1,date('Y'));
        $data = FinanceAdvertiserBillTerm::find()->andFilterWhere(['status' => 1])->andFilterWhere(['>=', 'create_time', $beginThisMonth])->all();
        return $data;
    }
}
