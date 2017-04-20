<?php

namespace backend\models;

use common\models\Advertiser;
use common\models\Campaign;
use common\models\Channel;
use Yii;

/**
 * This is the model class for table "finance_pending".
 *
 * @property integer $id
 * @property string $adv_bill_id
 * @property string $channel_bill_id
 * @property integer $adv_id
 * @property integer $campaign_id
 * @property integer $channel_id
 * @property integer $start_date
 * @property integer $end_date
 * @property integer $installs
 * @property integer $match_installs
 * @property string $adv_price
 * @property string $pay_out
 * @property string $cost
 * @property string $revenue
 * @property string $margin
 * @property string $adv
 * @property string $pm
 * @property string $bd
 * @property string $om
 * @property integer $status
 * @property string $note
 * @property integer $create_time
 * @property integer $update_time
 *
 * @property Advertiser $adv0
 * @property Campaign $campaign
 * @property Channel $channel
 */
class FinancePending extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'finance_pending';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['adv_id', 'campaign_id', 'channel_id', 'start_date', 'end_date', 'installs', 'match_installs', 'status', 'create_time', 'update_time'], 'integer'],
            [['campaign_id', 'channel_id', 'start_date', 'end_date'], 'required'],
            [['adv_price', 'pay_out', 'cost', 'revenue', 'margin'], 'number'],
            [['note'], 'string'],
            [['adv_bill_id', 'channel_bill_id', 'adv', 'pm', 'bd', 'om'], 'string', 'max' => 255],
            [['adv_id'], 'exist', 'skipOnError' => true, 'targetClass' => Advertiser::className(), 'targetAttribute' => ['adv_id' => 'id']],
            [['campaign_id'], 'exist', 'skipOnError' => true, 'targetClass' => Campaign::className(), 'targetAttribute' => ['campaign_id' => 'id']],
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
            'adv_bill_id' => 'Adv Bill ID',
            'channel_bill_id' => 'Channel Bill ID',
            'adv_id' => 'Adv ID',
            'campaign_id' => 'Campaign ID',
            'channel_id' => 'Channel ID',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'installs' => 'Installs',
            'match_installs' => 'Match Installs',
            'adv_price' => 'Adv Price',
            'pay_out' => 'Pay Out',
            'cost' => 'Cost',
            'revenue' => 'Revenue',
            'margin' => 'Margin',
            'adv' => 'Adv',
            'pm' => 'Pm',
            'bd' => 'Bd',
            'om' => 'Om',
            'status' => 'Status',
            'note' => 'Note',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdv0()
    {
        return $this->hasOne(Advertiser::className(), ['id' => 'adv_id']);
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
}
