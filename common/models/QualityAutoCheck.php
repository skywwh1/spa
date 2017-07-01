<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "quality_auto_check".
 *
 * @property integer $id
 * @property integer $campaign_id
 * @property string $campaign_name
 * @property integer $channel_id
 * @property string $channel_name
 * @property integer $is_send
 * @property integer $update_time
 * @property integer $create_time
 */
class QualityAutoCheck extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quality_auto_check';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign_id', 'channel_id'], 'required'],
            [['campaign_id', 'channel_id', 'is_send', 'update_time', 'create_time'], 'integer'],
            [['campaign_name', 'channel_name'], 'string', 'max' => 255],
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
            'campaign_name' => 'Campaign Name',
            'channel_id' => 'Channel ID',
            'channel_name' => 'Channel Name',
            'is_send' => 'Is Send',
            'update_time' => 'Update Time',
            'create_time' => 'Create Time',
        ];
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
