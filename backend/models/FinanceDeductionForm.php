<?php

namespace backend\models;

use common\models\Campaign;
use common\models\CampaignLogHourly;
use common\models\Channel;
use yii\base\Model;

class FinanceDeductionForm extends Model
{
    public $id;
    public $channel_name;
    public $campaign_id;
    public $channel_id;
    public $start_date;
    public $end_date;
    public $note;
    public $type;
    public $deduction_value;
    public $pending_id;

    public function rules()
    {
        return [
            [['campaign_id', 'channel_name', 'start_date', 'end_date', 'deduction_value'], 'required'],
            [['campaign_id', 'channel_id', 'start_date', 'end_date', 'type'], 'integer'],
            [['note'], 'string'],
            ['deduction_value', 'validateDeductionValue'],
            [['channel_name'], 'exist', 'skipOnError' => true, 'targetClass' => Channel::className(), 'targetAttribute' => ['channel_name' => 'username']],
            [['campaign_id'], 'exist', 'skipOnError' => true, 'targetClass' => Campaign::className(), 'targetAttribute' => ['campaign_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'campaign_id' => 'Campaign ID',
            'channel_id' => 'Channel ID',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'note' => 'Note',
            'type' => 'Type',
        ];
    }


    public function validateDeductionValue()
    {
        date_default_timezone_set('Etc/GMT-8');
        switch ($this->type) {
            case 1:
                if ($this->deduction_value < 1 || $this->deduction_value > 100) {
                    $this->addError('deduction_value', 'Discount must less than 100 and greater than 1');
                }
                break;
            case 2:
                break;
            case 3:
                break;
            default:
                break;
        }
        $records = CampaignLogHourly::findDateReport(strtotime($this->start_date), strtotime($this->end_date) + 3600 * 24, $this->campaign_id, $this->channel_id);
        if (empty($records)) {
            $this->addError('note', 'No data found in the report records');
        }

        $channel_bill_id = $this->channel_id . '_' . date('Ym', strtotime($this->start_date));
        $form = new FinancePendingForm();
        if(!$form->checkIsCheckedOut(null,$channel_bill_id)){
            $this->addError('note', 'Cannot deducted a closed bill');
        }
    }


}
