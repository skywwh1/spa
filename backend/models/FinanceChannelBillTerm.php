<?php

namespace backend\models;

use common\models\Campaign;
use common\models\Channel;
use Yii;

/**
 * This is the model class for table "finance_channel_bill_term".
 *
 * @property string $bill_id
 * @property string $invoice_id
 * @property string $period
 * @property integer $channel_id
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
 * @property string $add_historic_cost
 * @property string $pending
 * @property string $deduction
 * @property string $compensation
 * @property string $add_cost
 * @property string $final_cost
 * @property string $actual_margin
 * @property string $paid_amount
 * @property string $payable
 * @property string $apply_prepayment
 * @property string $balance
 * @property integer $status
 * @property string $note
 * @property integer $update_time
 * @property integer $create_time
 * @property string $adjust_cost
 * @property string $adjust_note
 *
 * @property FinanceAddCost[] $financeAddCosts
 * @property FinanceChannelPrepayment[] $financeApplyPrepayments
 * @property Channel $channel
 * @property FinanceChannelCampaignBillTerm[] $financeChannelCampaignBillTerms
 * @property Campaign[] $campaigns
 */
class FinanceChannelBillTerm extends \yii\db\ActiveRecord
{
    public $imageFiles;
    public $bank_name;
    public $bank_address;
    public $account_nu_iban;
    public $swift;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'finance_channel_bill_term';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['bill_id', 'invoice_id', 'period', 'channel_id', 'start_time', 'end_time'], 'required'],
            [['channel_id', 'start_time', 'end_time', 'clicks', 'unique_clicks', 'installs', 'match_installs', 'redirect_installs', 'redirect_match_installs', 'status', 'update_time', 'create_time'], 'integer'],
            [['pay_out', 'adv_price', 'cost', 'redirect_cost', 'revenue', 'redirect_revenue', 'add_historic_cost', 'pending', 'deduction', 'compensation', 'add_cost', 'final_cost', 'actual_margin', 'paid_amount', 'payable', 'apply_prepayment', 'balance','adjust_cost'], 'number'],
            [['note','adjust_note'], 'string'],
            [['bank_name','bank_address','account_nu_iban','swift'], 'safe'],
            [['bill_id', 'period'], 'string', 'max' => 255],
            [['invoice_id', 'time_zone', 'daily_cap', 'cap'], 'string', 'max' => 100],
            [['channel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Channel::className(), 'targetAttribute' => ['channel_id' => 'id']],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg', 'maxFiles' => 4],
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
            'channel_id' => 'Channel ID',
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
            'add_historic_cost' => 'Add Historic Cost',
            'pending' => 'Pending',
            'deduction' => 'Deduction',
            'compensation' => 'Compensation',
            'add_cost' => 'Add Cost',
            'final_cost' => 'Final Cost',
            'actual_margin' => 'Actual Margin',
            'paid_amount' => 'Paid Amount',
            'payable' => 'Payable',
            'apply_prepayment' => 'Apply Prepayment',
            'balance' => 'Balance',
            'status' => 'Status',
            'adjust_cost'=> 'Adjust Cost',
            'adjust_note' => 'Adjust Note',
            'note' => 'Note',
            'update_time' => 'Update Time',
            'create_time' => 'Create Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceAddCosts()
    {
        return $this->hasMany(FinanceAddCost::className(), ['channel_bill_id' => 'bill_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceApplyPrepayments()
    {
        return $this->hasMany(FinanceChannelPrepayment::className(), ['channel_bill_id' => 'bill_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChannel()
    {
        return $this->hasOne(Channel::className(), ['id' => 'channel_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceChannelCampaignBillTerms()
    {
        return $this->hasMany(FinanceChannelCampaignBillTerm::className(), ['bill_id' => 'bill_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaigns()
    {
        return $this->hasMany(Campaign::className(), ['id' => 'campaign_id'])->viaTable('finance_channel_campaign_bill_term', ['bill_id' => 'bill_id']);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->create_time = time();
        } else {
            $this->update_time = time();
        }
        return parent::beforeSave($insert); // TODO: Change the autogenerated stub
    }

    public static function countChaPending($bill_id,$cost,$revenue){
        $bill = FinanceChannelBillTerm::findOne($bill_id);
        if(!empty($bill)){
            $bill->pending = $bill->pending + $cost;
            $bill->final_cost = $bill->final_cost - $cost;
            $bill->payable = $bill->payable - $cost;
            $bill->revenue = $bill->revenue - $revenue;
            $bill->save();
        }
    }
}
