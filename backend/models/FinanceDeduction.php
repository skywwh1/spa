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

}
