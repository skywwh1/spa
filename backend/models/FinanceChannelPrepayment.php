<?php

namespace backend\models;

use common\models\Channel;
use Yii;

/**
 * This is the model class for table "finance_apply_prepayment".
 *
 * @property integer $id
 * @property string $channel_bill_id
 * @property integer $channel_id
 * @property string $timezone
 * @property string $prepayment
 * @property string $om
 * @property string $note
 * @property integer $create_time
 * @property integer $update_time
 *
 * @property FinanceChannelBillTerm $channelBill
 * @property Channel $channel
 */
class FinanceChannelPrepayment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'finance_channel_prepayment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channel_bill_id', 'channel_id', 'prepayment'], 'required'],
            [['channel_id', 'create_time', 'update_time'], 'integer'],
            [['prepayment'], 'number'],
            [['note'], 'string'],
            [['channel_bill_id', 'om'], 'string', 'max' => 255],
            [['timezone'], 'string', 'max' => 100],
            [['channel_bill_id'], 'exist', 'skipOnError' => true, 'targetClass' => FinanceChannelBillTerm::className(), 'targetAttribute' => ['channel_bill_id' => 'bill_id']],
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
            'channel_bill_id' => 'Channel Bill ID',
            'channel_id' => 'Channel ID',
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
    public function getChannelBill()
    {
        return $this->hasOne(FinanceChannelBillTerm::className(), ['bill_id' => 'channel_bill_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChannel()
    {
        return $this->hasOne(Channel::className(), ['id' => 'channel_id']);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if ($insert) {
            $bill = FinanceChannelBillTerm::findOne($this->channel_bill_id);
            $bill->apply_prepayment = $bill->apply_prepayment + $this->prepayment;
            $bill->save();
        }
        parent::afterSave($insert, $changedAttributes);
    }


}
