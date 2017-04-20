<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "finance_advertiser_prepayment".
 *
 * @property integer $id
 * @property string $advertiser_bill_id
 * @property integer $advertiser_id
 * @property string $timezone
 * @property string $prepayment
 * @property string $om
 * @property string $note
 * @property integer $create_time
 * @property integer $update_time
 *
 * @property FinanceAdvertiserBillTerm $advertiserBill
 */
class FinanceAdvertiserPrepayment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'finance_advertiser_prepayment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['advertiser_bill_id', 'advertiser_id', 'prepayment'], 'required'],
            [['advertiser_id', 'create_time', 'update_time'], 'integer'],
            [['prepayment'], 'number'],
            [['note'], 'string'],
            [['advertiser_bill_id', 'om'], 'string', 'max' => 255],
            [['timezone'], 'string', 'max' => 100],
            [['advertiser_bill_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinanceAdvertiserBillTerm::className(), 'targetAttribute' => ['advertiser_bill_id' => 'bill_id']],
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
            'prepayment' => 'Prepayment',
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
}
