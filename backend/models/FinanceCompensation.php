<?php

namespace backend\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "finance_compensation".
 *
 * @property integer $deduction_id
 * @property string $billable_cost
 * @property string $billable_revenue
 * @property string $billable_margin
 * @property string $compensation
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
            [['note'], 'string'],
            [['billable_cost', 'billable_revenue', 'billable_margin', 'compensation', 'final_margin'], 'number'],
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
            'billable_cost' => 'Billable Cost',
            'billable_revenue' => 'Billable Revenue',
            'billable_margin' => 'Billable Margin',
            'compensation' => 'Compensation',
            'final_margin' => 'Final Margin',
            'status' => 'Status',
            'editor' => 'Editor',
            'creator' => 'Creator',
            'note' => 'Note',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getDeduction()
    {
        return $this->hasOne(FinanceDeduction::className(), ['id' => 'deduction_id']);
    }
}
