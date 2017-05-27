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
     * @param $channel_bill_id
     * @return array
     */
    public static function getApprovedCompensation($deduction_ids)
    {
        return static::find()->andFilterWhere(['in', 'deduction_id',$deduction_ids])->andFilterWhere(['status' => 1])->all();
    }
}
