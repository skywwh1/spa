<?php

namespace backend\models;

use common\models\Advertiser;
use common\models\Campaign;
use common\models\CampaignLogHourly;
use common\models\Channel;
use common\models\Deliver;
use DateInterval;
use DateTime;
use DateTimeZone;
use Yii;
use yii\base\Model;

class FinancePendingForm extends Model
{
    public $campaign_id;
    public $channel_id;
    public $start_date;
    public $end_date;
    public $channel_name;
    public $is_all;
    public $adv_name;
    public $campaign_name;
    public $note;
    public $adv_id;
    public $type;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'start_date', 'end_date'], 'required'],
            [['adv_id', 'campaign_id', 'channel_id', 'type'], 'integer'],
            [['note'], 'string'],
            [['campaign_id'], 'exist', 'skipOnError' => true, 'targetClass' => Campaign::className(), 'targetAttribute' => ['campaign_id' => 'id']],
            [['channel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Channel::className(), 'targetAttribute' => ['channel_id' => 'id']],
            [['channel_name', 'is_all', 'adv_name'], 'safe'],
            [['channel_name'], 'validateBill', 'skipOnEmpty' => false, 'skipOnError' => true],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'adv_id' => 'Adv ID',
            'campaign_id' => 'Campaign ID',
            'channel_id' => 'Channel ID',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'note' => 'Note',
        ];
    }


    public function validateBill($attribute, $params, $validator)
    {
        date_default_timezone_set('Etc/GMT-8');
        if ($this->is_all == 0) {
            if ($_POST['FinancePending']['is_all'] == 0){
                if (empty($this->channel_id)) {
                    $this->addError('channel_name', 'Channel Name cannot be null');
                } else {
                    if (empty(Channel::findByUsername($this->channel_name))) {
                        $this->addError('channel_name', 'Channel Invalid');
                    }
                }
            }
        }

        //不能跨月
//        var_dump(strtotime($this->start_date));
//        die();
        if (date("m",strtotime($this->start_date)) != date("m",strtotime($this->end_date))) {
            $this->addError('channel_name', 'start date and end date must in the same month!');
        }
//        var_dump($this->type);
//        die();
//        var_dump($this->channel_id);
        if ($this->type == 1) { //campaign pending
            $adv_bill = $this->campaign_id . '_' . date('Ym', strtotime($this->start_date));
            if ($_POST['FinancePending']['is_all'] == 0) {
                $channel_bill = $this->channel_id . '_' . date('Ym', strtotime($this->start_date));
//                $this->checkPendingTime($this->campaign_id, 1, $channel_bill);
//                $this->checkPendingTime($this->campaign_id, 2, $adv_bill);
                if (!$this->checkRecords(strtotime($this->start_date), strtotime($this->end_date) + 3600 * 24, $this->campaign_id, $this->channel_id)) {
                    $this->addError('channel_name', 'it does`t have any report on this time');
                }
                if (!$this->checkIsCheckedOut(null,$channel_bill)){
                    $this->addError('note', 'the bill'.$channel_bill.'has been checked out!');
                }
            } else if ($_POST['FinancePending']['is_all'] == 1) {
                $delivers = Deliver::findAll(['channel_name' => $this->campaign_id]);
                foreach ($delivers as $item) {
                    $channel_bill = $item->channel_id . '_' . date('Ym', strtotime($this->start_date));
//                    $this->checkPendingTime($this->campaign_id, 1, $channel_bill);
                }
                $this->checkPendingTime($this->campaign_id, 2, $adv_bill);
            }
        } else if ($this->type == 2) {
            if (empty($this->adv_name)) {
                $this->addError('adv_name', 'ADV Name cannot be null');
            } else {
                $advertiser = Advertiser::getOneByUsername($this->adv_name);
                if (empty($advertiser)) {
                    $this->addError('adv_name', 'ADV invalid');
                }
//                var_dump($this->adv_name);
                $adv_bill = $advertiser->id . '_' . date('Ym', strtotime($this->start_date));

                if (!$this->checkIsCheckedOut($adv_bill,null)){
                    $this->addError('note', 'the bill '.$adv_bill.' has been checked out!');
                }
            }
        }


    }

    public function getChannelPending($channel_bill, $campaign_id)
    {
        return FinancePending::find()->where(['channel_bill_id' => $channel_bill, 'campaign_id' => $campaign_id])->all();
    }

    public function getAdvPending($adv_bill, $campaign_id)
    {
        return FinancePending::find()->where(['adv_bill_id' => $adv_bill, 'campaign_id' => $campaign_id])->all();
    }

    public function checkPendingTime($campaign_id, $bill_type, $bill_value)
    {
        date_default_timezone_set('Etc/GMT-8');
        //channel_pending
        if ($bill_type == 1) {
            $channel_pending = $this->getChannelPending($bill_value, $campaign_id);
            if (!empty($channel_pending)) {
                foreach ($channel_pending as $pending) {
                    if (strtotime($this->start_date) > $pending->start_date && strtotime($this->start_date) < $pending->end_date) {
                        $this->addError('channel_name', 'channel ' . $pending->channel_id . ' duplicate pending on this time');
                    }
                    if (strtotime($this->end_date) > $pending->start_date && strtotime($this->end_date) < $pending->end_date) {
                        $this->addError('channel_name', 'channel ' . $pending->channel_id . ' duplicate pending on this time');
                    }
                }
            }
        } else if ($bill_type == 2) { // adv pending
            $adv_pending = $this->getAdvPending($bill_value, $campaign_id);
            if (!empty($adv_pending)) {
                foreach ($adv_pending as $pending) {
                    if (strtotime($this->start_date) > $pending->start_date && strtotime($this->start_date) < $pending->end_date) {
                        $this->addError('channel_name', 'ADV ' . $pending->adv_id . ' duplicate pending on this time');
                    }
                    if (strtotime($this->end_date) > $pending->start_date && strtotime($this->end_date) < $pending->end_date) {
                        $this->addError('channel_name', 'ADV ' . $pending->adv_id . ' duplicate pending on this time');
                    }
                }
            }
        }
    }

    public function  checkRecords($start, $end, $campaign_id, $channel_id)
    {
        $records = CampaignLogHourly::findDateReport($start, $end, $campaign_id, $channel_id);
        if (empty($records)) {
            return false;
        }
        return true;
    }

    public function checkIsCheckedOut($adv_bill_id,$channel_bill_id)
    {
        $channel_bill = FinanceChannelBillTerm::findOne($channel_bill_id);
        if(!empty($channel_bill)) {
            if ($channel_bill->status == 7) {
                return false;
            }
        }
        $adv_bill = FinanceAdvertiserBillTerm::findOne($adv_bill_id);
        if(!empty($adv_bill)) {
            if ($adv_bill->status == 7) {
                return false;
            }
        }
        return true;
    }
}
