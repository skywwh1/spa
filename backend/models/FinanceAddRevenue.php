<?php

namespace backend\models;

use common\models\Advertiser;
use Yii;

/**
 * This is the model class for table "finance_add_revenue".
 *
 * @property integer $id
 * @property string $advertiser_bill_id
 * @property integer $advertiser_id
 * @property string $timezone
 * @property string $revenue
 * @property string $om
 * @property string $note
 * @property integer $create_time
 * @property integer $update_time
 * @property string $cost
 *
 * @property FinanceAdvertiserBillTerm $advertiserBill
 * @property Advertiser $advertiser
 */
class FinanceAddRevenue extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'finance_add_revenue';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['advertiser_bill_id', 'advertiser_id', 'revenue'], 'required'],
            [['advertiser_id', 'create_time', 'update_time'], 'integer'],
            [['revenue'], 'number'],
            [['cost'], 'number'],
            [['note'], 'string'],
            [['advertiser_bill_id', 'om'], 'string', 'max' => 255],
            [['timezone'], 'string', 'max' => 100],
            [['advertiser_bill_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinanceAdvertiserBillTerm::className(), 'targetAttribute' => ['advertiser_bill_id' => 'bill_id']],
            [['advertiser_id'], 'exist', 'skipOnError' => true, 'targetClass' => Advertiser::className(), 'targetAttribute' => ['advertiser_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'advertiser_bill_id' => 'Advertiser Bill ID',
            'advertiser_id' => 'Advertiser ID',
            'timezone' => 'Timezone',
            'revenue' => 'Revenue',
            'cost' => 'Cost',
            'om' => 'Om',
            'note' => 'Note',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertiserBill()
    {
        return $this->hasOne(FinanceAdvertiserBillTerm::className(), ['bill_id' => 'advertiser_bill_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertiser()
    {
        return $this->hasOne(Advertiser::className(), ['id' => 'advertiser_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            $bill = FinanceAdvertiserBillTerm::findOne($this->advertiser_bill_id);
            $bill->add_revenue = $bill->add_revenue + $this->revenue;
            $bill->final_revenue = $bill->final_revenue + $this->revenue;
            $bill->receivable = $bill->receivable + $this->revenue;
//            Actual margin = （Receivable -Final Cost)/ Receivable
            $bill->cost = $bill->cost + $this->cost;
            $bill->add_cost += $bill->cost;
//            $bill->actual_margin = 1 - $bill->cost/$bill->receivable;
            $bill->save();
        }

        parent::afterSave($insert, $changedAttributes);
    }
}
