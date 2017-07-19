<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "email_content".
 *
 * @property integer $id
 * @property integer $channel_id
 * @property integer $campaign_id
 * @property string $content
 * @property integer $create_time
 *
 * @property Campaign $campaign
 * @property Channel $channel
 */
class EmailContent extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'email_content';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channel_id', 'campaign_id', 'create_time'], 'integer'],
            [['content'], 'string'],
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
            'channel_id' => 'Channel ID',
            'campaign_id' => 'Campaign ID',
            'content' => 'Content',
            'create_time' => 'Create Time',
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

    public  function beforeSave($insert){
        if(parent::beforeSave($insert)){
            if($insert){
                $this->create_time = time();
            }
            return true;
        }
        return false;
    }

}
