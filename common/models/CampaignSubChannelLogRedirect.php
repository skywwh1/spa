<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "campaign_sub_channel_log_redirect".
 *
 * @property integer $id
 * @property integer $campaign_id
 * @property integer $channel_id
 * @property integer $campaign_id_new
 * @property string $sub_channel
 * @property string $daily_cap
 * @property string $actual_discount
 * @property string $discount
 * @property integer $discount_numerator
 * @property integer $discount_denominator
 * @property integer $status
 * @property integer $end_time
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $creator
 *
 * @property Campaign $campaign
 * @property Campaign $campaignIdNew
 * @property Channel $channel
 * @property User $creator0
 */
class CampaignSubChannelLogRedirect extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'campaign_sub_channel_log_redirect';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'campaign_id', 'channel_id','sub_channel'], 'required'],
            [['id', 'campaign_id', 'channel_id', 'campaign_id_new', 'discount_numerator', 'discount_denominator', 'status', 'end_time', 'update_time', 'creator'], 'integer'],
            [['actual_discount', 'discount'], 'number'],
            [['daily_cap'], 'string', 'max' => 100],
            [['campaign_id'], 'exist', 'skipOnError' => true, 'targetClass' => Campaign::className(), 'targetAttribute' => ['campaign_id' => 'id']],
            [['campaign_id_new'], 'exist', 'skipOnError' => true, 'targetClass' => Campaign::className(), 'targetAttribute' => ['campaign_id_new' => 'id']],
            [['channel_id'], 'exist', 'skipOnError' => true, 'targetClass' => Channel::className(), 'targetAttribute' => ['channel_id' => 'id']],
            [['creator'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator' => 'id']],
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
            'campaign_id_new' => 'Campaign Id New',
            'daily_cap' => 'Daily Cap',
            'actual_discount' => 'Actual Discount',
            'discount' => 'Discount',
            'discount_numerator' => 'Discount Numerator',
            'discount_denominator' => 'Discount Denominator',
            'status' => 'Status',
            'end_time' => 'End Time',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
            'creator' => 'Creator',
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
    public function getCampaignIdNew()
    {
        return $this->hasOne(Campaign::className(), ['id' => 'campaign_id_new']);
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
    public function getCreator0()
    {
        return $this->hasOne(User::className(), ['id' => 'creator']);
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

    /**
     * @param $campaign_id
     * @param $channel_id
     * @param $sub_channel
     * @return CampaignSubChannelLogRedirect
     */
    public static function findIsActive($campaign_id, $channel_id,$sub_channel)
    {
        return static::find()->where([ 'campaign_id' => $campaign_id, 'channel_id' => $channel_id,'sub_channel' => $sub_channel])->orderBy('create_time desc')->one();
    }

}
