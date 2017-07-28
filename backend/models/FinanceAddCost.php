<?php

namespace backend\models;

use common\models\Channel;
use Yii;

/**
 * This is the model class for table "finance_add_cost".
 *
 * @property integer $id
 * @property string $channel_bill_id
 * @property integer $channel_id
 * @property string $timezone
 * @property string $cost
 * @property string $om
 * @property string $note
 * @property integer $create_time
 * @property integer $update_time
 * @property string $revenue
 *
 * @property Channel $channel
 * @property FinanceChannelBillTerm $channelBill
 */
class FinanceAddCost extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'finance_add_cost';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channel_bill_id', 'channel_id', 'cost','revenue'], 'required'],
            [['channel_id', 'create_time', 'update_time'], 'integer'],
            [['cost'], 'number'],
            [['revenue'], 'number'],
            [['note'], 'string'],
            [['channel_bill_id', 'om'], 'string', 'max' => 255],
            [['timezone'], 'string', 'max' => 100],
            [['channel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Channel::className(), 'targetAttribute' => ['channel_id' => 'id']],
            [['channel_bill_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinanceChannelBillTerm::className(), 'targetAttribute' => ['channel_bill_id' => 'bill_id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'channel_bill_id' => 'Channel Bill ID',
            'channel_id' => 'Channel ID',
            'timezone' => 'Timezone',
            'cost' => 'Cost',
            'revenue' => 'Revenue',
            'om' => 'Om',
            'note' => 'Note',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
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
    public function getChannelBill()
    {
        return $this->hasOne(FinanceChannelBillTerm::className(), ['bill_id' => 'channel_bill_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            $bill = FinanceChannelBillTerm::findOne($this->channel_bill_id);
            $bill->add_cost = $bill->add_cost + $this->cost;
            $bill->final_cost = $bill->final_cost + $this->cost;
            $bill->payable = $bill->payable + $this->cost;
            //渠道 Actual margin = （Final Revenue -Payable）／Final Revenue
            $bill->revenue = $bill->revenue + $this->revenue;
            $bill->add_revenue += $this->revenue;
//            $bill->actual_margin = 1 - $bill->payable/$bill->revenue;
            $bill->save();
        }
        parent::afterSave($insert, $changedAttributes);
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
}
