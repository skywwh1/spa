<?php

namespace backend\models;

use common\models\Campaign;
use common\models\CampaignLogHourly;
use common\models\Channel;
use DateInterval;
use DateTime;
use DateTimeZone;
use Yii;

/**
 * This is the model class for table "finance_deduction".
 *
 * @property integer $id
 * @property string $adv_bill_id
 * @property string $channel_bill_id
 * @property integer $campaign_id
 * @property integer $channel_id
 * @property string $timezone
 * @property integer $start_date
 * @property integer $end_date
 * @property integer $installs
 * @property integer $match_installs
 * @property string $cost
 * @property string $deduction_value
 * @property string $deduction_cost
 * @property string $deduction_revenue
 * @property string $revenue
 * @property string $margin
 * @property string $adv
 * @property string $pm
 * @property string $bd
 * @property string $om
 * @property integer $status
 * @property string $note
 * @property integer $type
 * @property integer $create_time
 * @property integer $update_time
 *
 * @property FinanceCompensation $financeCompensation
 * @property Campaign $campaign
 * @property Channel $channel
 * @property FinanceAdvertiserBillTerm $advBill
 */
class FinanceDeduction extends \yii\db\ActiveRecord
{
    public $channel_name;
    public $communicating_revenue;
    public $communicating_cost;
    public $confirm_revenue;
    public $confirm_cost;
    public $compensated_revenue;
    public $compensated_cost;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'finance_deduction';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['adv_bill_id', 'channel_bill_id', 'campaign_id', 'channel_id', 'start_date', 'end_date'], 'required'],
            [['campaign_id', 'channel_id', 'start_date', 'end_date', 'installs', 'match_installs', 'status', 'type', 'create_time', 'update_time'], 'integer'],
            [['cost', 'deduction_value', 'deduction_cost', 'deduction_revenue', 'revenue', 'margin'], 'number'],
            [['note'], 'string'],
            [['channel_name'], 'exist', 'skipOnError' => true, 'targetClass' => Channel::className(), 'targetAttribute' => ['channel_name' => 'username']],
            [['adv_bill_id', 'channel_bill_id', 'adv', 'pm', 'bd', 'om'], 'string', 'max' => 255],
            [['timezone'], 'string', 'max' => 100],
            [['campaign_id'], 'exist', 'skipOnError' => true, 'targetClass' => Campaign::className(), 'targetAttribute' => ['campaign_id' => 'id']],
            [['channel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Channel::className(), 'targetAttribute' => ['channel_id' => 'id']],
            [['adv_bill_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinanceAdvertiserBillTerm::className(), 'targetAttribute' => ['adv_bill_id' => 'bill_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'adv_bill_id' => 'Adv Bill ID',
            'channel_bill_id' => 'Channel Bill ID',
            'campaign_id' => 'Campaign ID',
            'channel_id' => 'Channel ID',
            'timezone' => 'Timezone',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'installs' => 'Installs',
            'match_installs' => 'Match Installs',
            'cost' => 'Cost',
            'deduction_value' => 'Deduction Value',
            'deduction_cost' => 'Deduction Cost',
            'deduction_revenue' => 'Deduction Revenue',
            'revenue' => 'Revenue',
            'margin' => 'Margin',
            'adv' => 'Adv',
            'pm' => 'Pm',
            'bd' => 'Bd',
            'om' => 'Om',
            'status' => 'Status',
            'note' => 'Note',
            'type' => 'Type',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getFinanceCompensation()
    {
        return $this->hasOne(FinanceCompensation::className(), ['deduction_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaign()
    {
        return $this->hasOne(Campaign::className(), ['id' => 'campaign_id']);
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
    public function getAdvBill()
    {
        return $this->hasOne(FinanceAdvertiserBillTerm::className(), ['bill_id' => 'adv_bill_id']);
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

    /**
     * @param $channel_bill_id
     * @return array
     */
    public static function getDeductionIds($channel_bill_id)
    {
        return static::find()->select(['id'])->where(['channel_bill_id' => $channel_bill_id])->column();
    }

    /**
     * @param $channel_bill_id
     * @return array
     */
    public static function getConfirmOrCompensatedDeduction($channel_bill_id)
    {
        return static::find()->where(['channel_bill_id' => $channel_bill_id])->andFilterWhere(['<>', 'status', 0])->all();
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert){
            //对于渠道需要confirm才能去计算deduction的值
            if ($this->status >0 ) {
                $this->countDeductionChannelBillTerm();
            }
            $this->countDeductionAdvBillTerm();
            parent::afterSave($insert, $changedAttributes);
        }
    }

    /**计算pending的
     * countPending
     */
    private function countDeductionChannelBillTerm(){
        $channel_bill = FinanceChannelBillTerm::findOne($this->channel_bill_id);
        /**
         * 一个账单被设置成deduction,则看其是否过期
         * */
        if(!empty($channel_bill)){
            //如果该账单已经结束，则将该账单放到最近的某个月的利润
            if ($channel_bill->status == 7){
                //将账单的cost和revenue放到最近的一个月的账单上面
//                $recent_not_ending_bill = FinanceChannelBillTerm::findRecentNotEndingBill($channel_bill);
//                $recent_not_ending_bill->add_historic_cost -= $this->deduction_cost;
//                $recent_not_ending_bill->final_cost = $recent_not_ending_bill->final_cost - $this->cost;
//                $recent_not_ending_bill->payable = $recent_not_ending_bill->payable - $this->cost;
//                $recent_not_ending_bill->revenue -= $this->deduction_revenue;
//                $recent_not_ending_bill->save();
//
//                $this->resetChannelBillIdNew($this->id,$recent_not_ending_bill);//对于已经已经结款的单子，我们处理账单的时候需要重新关联到对应的账单
            }else{
                //如果账单没有结束，则将deduction的账目放到本账单上面
                $channel_bill->deduction += $this->deduction_cost;
                $channel_bill->final_cost = $channel_bill->final_cost - $this->deduction_cost;
                $channel_bill->payable = $channel_bill->payable - $this->deduction_cost;
                $channel_bill->revenue -= $this->deduction_revenue;
                $channel_bill->deduction_revenue += $this->deduction_revenue;
                $channel_bill->save();
            }
        }
    }

    private function countDeductionAdvBillTerm(){
        $adv_bill = FinanceAdvertiserBillTerm::findOne($this->adv_bill_id);
        if(!empty($adv_bill)){
            //如果该账单已经结束，则将该账单放到最近的某个月的利润
            if ($adv_bill->status == 7){
                //将账单的cost和revenue放到最近的一个月的账单上面
//                $recent_not_ending_bill = FinanceAdvertiserBillTerm::findRecentNotEndingBill($adv_bill);
//                $recent_not_ending_bill->add_historic -= $this->deduction_revenue;
//                $recent_not_ending_bill->final_revenue = $recent_not_ending_bill->final_revenue - $this->revenue;
//                $recent_not_ending_bill->receivable = $recent_not_ending_bill->receivable - $this->revenue;
//                $recent_not_ending_bill->cost -= $this->deduction_cost;
//                $recent_not_ending_bill->save();
//
//                $this->resetAdvBillIdNew($recent_not_ending_bill);//对于已经已经结款的单子，我们处理账单的时候需要重新关联到对应的账单
            }else{
                //如果账单没有结束，则将pending的账目放到本账单上面、
                $adv_bill->deduction = $adv_bill->deduction + $this->deduction_revenue;
                $adv_bill->final_revenue = $adv_bill->final_revenue - $this->deduction_revenue;
                $adv_bill->receivable = $adv_bill->receivable - $this->deduction_revenue;
                $adv_bill->cost -= $this->deduction_cost;
                $adv_bill->deduction_cost += $this->deduction_cost;
                $adv_bill->save();
            }
        }
    }

    /**
     * 对于已经已经结款的单子，我们处理账单的时候需要重新关联到对应的账单
     * @param $recent_not_ending_bill
     */
    private function resetChannelBillIdNew($recent_not_ending_bill){
        $financePending = FinanceDeduction::findOne($this->id);
        $financePending->channel_bill_id_new = $recent_not_ending_bill->channel_bill_id;
        $financePending->save();
    }

    /**
     * 对于已经已经结款的单子，我们处理账单的时候需要重新关联到对应的账单
     * @param $recent_not_ending_bill
     */
    private function resetAdvBillIdNew($recent_not_ending_bill){
        $financePending = FinanceDeduction::findOne($this->id);
        $financePending->adv_bill_id_new = $recent_not_ending_bill->adv_bill_id;
        $financePending->save();
    }

    /**
     * @param $old_deduction_cost
     * @param $old_deduction_revenue
     */
    private function updateDeductionChannelBillTerm($old_deduction_cost,$old_deduction_revenue){
        $channel_bill = FinanceChannelBillTerm::findOne($this->channel_bill_id);
        /**
         * 一个账单被设置成deduction,则看其是否过期
         * */
        if(!empty($channel_bill)){
            //如果该账单已经结束，则将该账单放到最近的某个月的利润
            if ($channel_bill->status == 7){
                //将账单的cost和revenue放到最近的一个月的账单上面
            }else{
                //如果账单没有结束，则将deduction的账目放到本账单上面
                $diff_cost =  $old_deduction_cost - $this->deduction_cost;
                $diff_revenue =  $old_deduction_revenue - $this->deduction_revenue;
                $channel_bill->deduction +=   $this->deduction_cost - $old_deduction_cost;
                $channel_bill->final_cost = $channel_bill->final_cost + $diff_cost;
                $channel_bill->payable = $channel_bill->payable + $diff_cost;
                $channel_bill->revenue += $this->deduction_revenue - $old_deduction_revenue;
                $channel_bill->deduction_revenue += $this->deduction_revenue - $old_deduction_revenue;
                $channel_bill->save();
            }
        }
    }

    /**
     * @param $old_deduction_cost
     * @param $old_deduction_revenue
     */
    private function updateDeductionAdvBillTerm($old_deduction_cost,$old_deduction_revenue){
        $adv_bill = FinanceAdvertiserBillTerm::findOne($this->adv_bill_id);
        if(!empty($adv_bill)){
            //如果该账单已经结束，则将该账单放到最近的某个月的利润
            if ($adv_bill->status == 7){
                //将账单的cost和revenue放到最近的一个月的账单上面
            }else{
                //如果账单没有结束，则将pending的账目放到本账单上面、
                $diff_cost =  $old_deduction_cost - $this->deduction_cost;
                $diff_revenue = $old_deduction_revenue - $this->deduction_revenue;
                $adv_bill->deduction +=  $this->deduction_revenue - $old_deduction_revenue;
                $adv_bill->final_revenue = $adv_bill->final_revenue + $diff_revenue;
                $adv_bill->receivable = $adv_bill->receivable + $diff_revenue;
                $adv_bill->cost += $this->deduction_cost - $old_deduction_cost;
                $adv_bill->deduction_cost += $this->deduction_cost - $old_deduction_cost;
                $adv_bill->save();
            }
        }
    }

    public function updateCost($old_deduction_cost,$old_deduction_revenue){
        $this->updateDeductionChannelBillTerm($old_deduction_cost,$old_deduction_revenue);
        $this->updateDeductionAdvBillTerm($old_deduction_cost,$old_deduction_revenue);
    }
}
