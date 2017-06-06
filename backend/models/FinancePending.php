<?php

namespace backend\models;

use common\models\Advertiser;
use common\models\Campaign;
use common\models\CampaignLogHourly;
use common\models\Channel;
use Yii;

/**
 * This is the model class for table "finance_pending".
 *
 * @property integer $id
 * @property string $adv_bill_id
 * @property string $channel_bill_id
 * @property string $adv_bill_id_new
 * @property string $channel_bill_id_new
 * @property integer $adv_id
 * @property integer $campaign_id
 * @property integer $channel_id
 * @property integer $start_date
 * @property integer $end_date
 * @property integer $installs
 * @property integer $match_installs
 * @property string $adv_price
 * @property string $pay_out
 * @property string $cost
 * @property string $revenue
 * @property string $margin
 * @property string $adv
 * @property string $pm
 * @property string $bd
 * @property string $om
 * @property integer $status
 * @property string $note
 * @property integer $create_time
 * @property integer $update_time
 *
 * @property Advertiser $adv0
 * @property Campaign $campaign
 * @property Channel $channel
 */
class FinancePending extends \yii\db\ActiveRecord
{
    public $adv_name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'finance_pending';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['adv_id', 'campaign_id', 'channel_id', 'start_date', 'end_date', 'installs', 'match_installs', 'status', 'create_time', 'update_time'], 'integer'],
            [['campaign_id', 'channel_id', 'start_date', 'end_date'], 'required'],
            [['adv_price', 'pay_out', 'cost', 'revenue', 'margin'], 'number'],
            [['note'], 'validateDeductionValue'],
            [['adv_bill_id', 'channel_bill_id','adv_bill_id_new', 'channel_bill_id_new', 'adv', 'pm', 'bd', 'om'], 'string', 'max' => 255],
            [['adv_id'], 'exist', 'skipOnError' => true, 'targetClass' => Advertiser::className(), 'targetAttribute' => ['adv_id' => 'id']],
            [['campaign_id'], 'exist', 'skipOnError' => true, 'targetClass' => Campaign::className(), 'targetAttribute' => ['campaign_id' => 'id']],
            [['channel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Channel::className(), 'targetAttribute' => ['channel_id' => 'id']],
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
            'adv_id' => 'Adv ID',
            'campaign_id' => 'Campaign ID',
            'channel_id' => 'Channel ID',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'installs' => 'Installs',
            'match_installs' => 'Match Installs',
            'adv_price' => 'Adv Price',
            'pay_out' => 'Pay Out',
            'cost' => 'Cost',
            'revenue' => 'Revenue',
            'margin' => 'Margin',
            'adv' => 'Adv',
            'pm' => 'Pm',
            'bd' => 'Bd',
            'om' => 'Om',
            'status' => 'Status',
            'note' => 'Note',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdv0()
    {
        return $this->hasOne(Advertiser::className(), ['id' => 'adv_id']);
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
     * @param $campaign_id
     * @param $channel_id
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findPendingByCamAndChannel($campaign_id, $channel_id)
    {
        $query = FinancePending::find();

        // grid filtering conditions
        $query->andFilterWhere([
            'campaign_id' => $campaign_id,
            'channel_id' => $channel_id,

        ]);
        return $query->all();
    }

    /**
     * @param $channel_bill_id
     * @param $adv_bill_id
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getHistoricFinancePending($channel_bill_id,$adv_bill_id)
    {
        return static::find()->andFilterWhere(['channel_bill_id' => $channel_bill_id])->andFilterWhere(['adv_bill_id' => $adv_bill_id])->andFilterWhere(['status' => 1])->all();
    }

    public  function beforeSave($insert){
        if(parent::beforeSave($insert)){
            if($insert){
                $this->create_time = time();
                $this->update_time = time();
            }else{
                $this->update_time = time();
            }
            return true;
        }
        return false;
    }

    public function afterSave($insert, $changedAttributes)
    {
        if($this->status == 0){
            $this->countPendingChannelBillTerm();
            $this->countPendingAdvBillTerm();
        }else{
            $this->countConfirmChannelBillTerm();
            $this->countConfirmAdvertiserBillTerm();
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**计算pending的
     * countPending
     */
    private function countPendingChannelBillTerm(){
        $channel_bill = FinanceChannelBillTerm::findOne($this->channel_bill_id);
        /**
         * 一个账单被设置成pending,则看其是否过期
         * 过期的话就会有historic_cost；
         * */
        if(!empty($channel_bill)){
            //如果该账单已经结束，则将该账单放到最近的某个月的利润
            if ($channel_bill->status == 7){
                //将账单的cost和revenue放到最近的一个月的账单上面
//                $recent_not_ending_bill = FinanceChannelBillTerm::findRecentNotEndingBill($channel_bill);
//                $recent_not_ending_bill->pending += $this->cost;
//                $recent_not_ending_bill->save();
//
//                $this->resetChannelBillIdNew($this->id,$recent_not_ending_bill);//对于已经已经结款的单子，我们处理账单的时候需要重新关联到对应的账单
            }else{
                //如果账单没有结束，则将解禁的账目放到本账单上面
                $channel_bill->pending += $this->cost;
                $channel_bill->final_cost = $channel_bill->final_cost - $this->cost;
                $channel_bill->payable = $channel_bill->payable - $this->cost;
                $channel_bill->revenue -= $this->revenue;//TODO maybe revenue will be changed;
                $channel_bill->save();
            }
        }
    }

    private function countPendingAdvBillTerm(){
        $adv_bill = FinanceAdvertiserBillTerm::findOne($this->adv_bill_id);
        if(!empty($adv_bill)){
            //如果该账单已经结束，则将该账单放到最近的某个月的利润
            if ($adv_bill->status == 7){
                //将账单的cost和revenue放到最近的一个月的账单上面
//                $recent_not_ending_bill = FinanceAdvertiserBillTerm::findRecentNotEndingBill($adv_bill);
//                $recent_not_ending_bill->pending += $this->revenue;
//                $recent_not_ending_bill->save();
//                $this->resetAdvBillIdNew($recent_not_ending_bill);//对于已经已经结款的单子，我们处理账单的时候需要重新关联到对应的账单
            }else{
                //如果账单没有结束，则将pending的账目放到本账单上面、
                $adv_bill->pending = $adv_bill->pending + $this->revenue;
                $adv_bill->final_revenue = $adv_bill->final_revenue - $this->revenue;
                $adv_bill->receivable = $adv_bill->receivable - $this->revenue;
                $adv_bill->cost -= $this->cost;
                $adv_bill->save();
            }
        }
    }

    /**
     * 查询账单的数据，
     */
    private function countConfirmChannelBillTerm(){
        $channel_bill = FinanceChannelBillTerm::findOne($this->channel_bill_id);
        if(!empty($channel_bill)){
            //如果该账单已经结束，则将该账单放到最近的某个月的利润
            if ($channel_bill->status == 7){
                //将账单的cost和revenue放到最近的一个月的账单上面
                $recent_not_ending_bill = FinanceChannelBillTerm::findRecentNotEndingBill($channel_bill);
                $recent_not_ending_bill->add_historic_cost += $this->cost;
                $recent_not_ending_bill->final_cost = $recent_not_ending_bill->final_cost + $this->cost;
                $recent_not_ending_bill->payable = $recent_not_ending_bill->payable + $this->cost;
                $recent_not_ending_bill->revenue += $this->revenue;
                $recent_not_ending_bill->save();

                $this->resetChannelBillIdNew($recent_not_ending_bill);//对于已经已经结款的单子，我们处理账单的时候需要重新关联到对应的账单
            }else{
                //如果账单没有结束，则将解禁的账目放到本账单上面
                $channel_bill->final_cost = $channel_bill->final_cost + $this->cost;
                $channel_bill->payable = $channel_bill->payable + $this->cost;
                $channel_bill->pending -= $this->cost;
                $channel_bill->revenue += $this->revenue;
                $channel_bill->save();

            }
        }
    }

    private function countConfirmAdvertiserBillTerm(){
        $adv_bill = FinanceAdvertiserBillTerm::findOne($this->adv_bill_id);
        if(!empty($adv_bill)){
            //如果该账单已经结束，则将该账单放到最近的某个月的利润
            if ($adv_bill->status == 7){
                //将账单的cost和revenue放到最近的一个月的账单上面
                $recent_not_ending_bill = FinanceAdvertiserBillTerm::findRecentNotEndingBill($adv_bill);
                $recent_not_ending_bill->add_historic += $this->revenue;
                $recent_not_ending_bill->final_revenue = $recent_not_ending_bill->final_revenue + $this->revenue;
                $recent_not_ending_bill->receivable = $recent_not_ending_bill->receivable + $this->revenue;
                $recent_not_ending_bill->cost += $this->cost;
                $recent_not_ending_bill->save();

                $this->resetAdvBillIdNew($recent_not_ending_bill);//对于已经已经结款的单子，我们处理账单的时候需要重新关联到对应的账单
            }else{
                //如果账单没有结束，则将解禁的账目放到本账单上面
                $adv_bill->final_revenue = $adv_bill->final_revenue + $this->revenue;
                $adv_bill->receivable = $adv_bill->receivable + $this->revenue;
                $adv_bill->pending -= $this->revenue;
                $adv_bill->cost += $this->cost;
                $adv_bill->save();
            }
        }
    }

    /**
     * 对于已经已经结款的单子，我们处理账单的时候需要重新关联到对应的账单
     * @param $recent_not_ending_bill
     */
    private function resetChannelBillIdNew($recent_not_ending_bill){
        $financePending = FinancePending::findOne($this->id);
        $financePending->channel_bill_id_new = $recent_not_ending_bill->bill_id;
        $financePending->save();
    }

    /**
     * 对于已经已经结款的单子，我们处理账单的时候需要重新关联到对应的账单
     * @param $recent_not_ending_bill
     */
    private function resetAdvBillIdNew($recent_not_ending_bill){
        $financePending = FinancePending::findOne($this->id);
        $financePending->adv_bill_id_new = $recent_not_ending_bill->bill_id;
        $financePending->save();
    }

    public function validateDeductionValue()
    {
        date_default_timezone_set('Etc/GMT-8');
        if ($this->status >0 ){
            return;
        }
        $records = CampaignLogHourly::findDateReport(strtotime($this->start_date), strtotime($this->end_date) + 3600 * 24, $this->campaign_id, $this->channel_id);
        if (empty($records)) {
            $this->addError('note', 'No data found in the report records');
        }
    }

    /**
     * @param $id
     */
    public static function confirmPending($id){
        $financePending = FinancePending::findOne($id);
        $financePending->status = 1;
        $financePending->save();
    }

}
