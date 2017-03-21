<?php

namespace backend\models;

use common\models\Campaign;
use common\models\Channel;
use Yii;

/**
 * This is the model class for table "finance_pending".
 *
 * @property integer $id
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
 * @property Campaign $campaign
 * @property Channel $channel
 */
class FinancePending extends \yii\db\ActiveRecord
{
    public $channel_name;
    public $is_all;
    public $adv_name;
    public $campaign_name;

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
            [['campaign_id', 'channel_id', 'start_date', 'end_date'], 'required'],
            [['campaign_id', 'channel_id', 'start_date', 'end_date', 'installs', 'match_installs', 'status', 'create_time', 'update_time'], 'integer'],
            [['adv_price', 'pay_out', 'cost', 'revenue', 'margin'], 'number'],
            [['note'], 'string'],
            [['adv', 'pm', 'bd', 'om'], 'string', 'max' => 255],
            [['campaign_id'], 'exist', 'skipOnError' => true, 'targetClass' => Campaign::className(), 'targetAttribute' => ['campaign_id' => 'id']],
            [['channel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Channel::className(), 'targetAttribute' => ['channel_id' => 'id']],
            [['channel_name', 'is_all', 'adv_name'], 'safe'],
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
