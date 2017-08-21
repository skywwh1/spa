<?php

namespace backend\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
/**
 * This is the model class for table "invoice_picture".
 *
 * @property integer $id
 * @property string $channel_bill_id
 * @property string $path
 * @property integer $create_time
 * @property integer $update_time
 *
 * @property FinanceChannelBillTerm $channelBill
 */
class InvoicePicture extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'invoice_picture';
    }

    public function behaviors(){
        return [
            [
                'class'=>TimestampBehavior::className(),
                'attributes'=>[
                    ActiveRecord::EVENT_BEFORE_INSERT => ['create_time','update_time'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['create_time'],
                ]
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['create_time', 'update_time'], 'integer'],
            [['channel_bill_id', 'path'], 'string', 'max' => 255],
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
            'path' => 'Path',
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
}
