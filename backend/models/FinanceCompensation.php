<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "finance_compensation".
 *
 * @property integer $deduction_id
 * @property string $compensation
 * @property string $billable_cost
 * @property string $billable_revenue
 * @property string $billable_margin
 * @property string $final_margin
 * @property integer $status
 * @property integer $editor
 * @property integer $creator
 * @property string $note
 *
 * @property FinanceDeduction $deduction
 */
class FinanceCompensation extends ActiveRecord
{
    public $channel;
    public $campaign_id;
    public $campaign_name;
    public $start_date;
    public $end_date;
//    public $deduction;
    public $deduction_revenue;
    public $deduction_cost;
    public $system_cost;
    public $system_revenue;
    public $final_margin;
    public $note;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'finance_compensation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['deduction_id', 'compensation'], 'required'],
            [['deduction_id', 'status', 'editor', 'creator'], 'integer'],
            [['compensation', 'billable_cost', 'billable_revenue', 'billable_margin', 'final_margin'], 'number'],
            [['note'], 'safe'],
            [['deduction_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinanceDeduction::className(), 'targetAttribute' => ['deduction_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'deduction_id' => 'Deduction ID',
            'compensation' => 'Compensation',
            'billable_cost' => 'Billable Cost',
            'billable_revenue' => 'Billable Revenue',
            'billable_margin' => 'Billable Margin',
            'final_margin' => 'Final Margin',
            'status' => 'Status',
            'editor' => 'Editor',
            'creator' => 'Creator',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeduction()
    {
        return $this->hasOne(FinanceDeduction::className(), ['id' => 'deduction_id']);
    }

    /**
     * @param $deduction_ids
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getApprovedCompensation($deduction_ids)
    {
        return static::find()->andFilterWhere(['in', 'deduction_id',$deduction_ids])->andFilterWhere(['status' => 1])->all();
    }

    public function afterSave($insert, $changedAttributes)
    {
        if($this->status == 1){
            $this->countCompensationChannelBillTerm();
        }
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * 计算compensation的
     * countCompensationChannelBillTerm
     */
    private function countCompensationChannelBillTerm(){
        $deduction = FinanceDeduction::findOne(['id' => $this->deduction_id]);
        if (!empty($deduction)){
            $channel_bill = FinanceChannelBillTerm::findOne($deduction->channel_bill_id);
            /**
             * 一个账单被设置成compensation,则看其是否过期
             * */
            if(!empty($channel_bill)){
                //如果该账单已经结束，则将该账单放到最近的某个月的利润
                if ($channel_bill->status == 7){
                    //将账单的cost和revenue放到最近的一个月的账单上面
//                    $new_channel_bill = FinanceChannelBillTerm::findOne($deduction->channel_bill_id_new);
//                    $new_channel_bill->add_historic_cost += $this->compensation;
//                    $new_channel_bill->payable = $new_channel_bill->payable + $this->compensation;
//                    $new_channel_bill->save();
                }else{
                    //如果账单没有结束，则将compensation的账目放到本账单上面
                    $channel_bill->compensation += $this->compensation;
                    $channel_bill->payable = $channel_bill->payable + $this->compensation;
                    $channel_bill->save();
                }
            }
        }
    }
}
