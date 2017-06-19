<?php

namespace common\models;

use phpDocumentor\Reflection\Types\Static_;
use Yii;

/**
 * This is the model class for table "campaign_sub_channel_log".
 *
 * @property integer $id
 * @property integer $campaign_id
 * @property integer $channel_id
 * @property string $sub_channel
 * @property integer $is_send
 * @property string $name
 * @property integer $is_effected
 * @property integer $effect_time
 * @property integer $create_time
 * @property integer $creator
 *
 * @property Campaign $campaign
 * @property Channel $channel
 * @property User $creator0
 */
class CampaignSubChannelLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'campaign_sub_channel_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign_id', 'is_send', 'effect_time'], 'required'],
            [['campaign_id', 'channel_id', 'is_send', 'is_effected', 'create_time', 'creator'], 'integer'],
            [['sub_channel', 'name'], 'string', 'max' => 255],
            [['campaign_id'], 'exist', 'skipOnError' => true, 'targetClass' => Campaign::className(), 'targetAttribute' => ['campaign_id' => 'id']],
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
            'sub_channel' => 'Sub Channel',
            'is_send' => 'Is Send',
            'name' => 'Name',
            'is_effected' => 'Is Effected',
            'effect_time' => 'Effect Time',
            'create_time' => 'Create Time',
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
            }
            return true;
        }
        return false;
    }

    /**
     * 获取所有生效时间在当前时间之前且未生效的数据
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getNeedPause()
    {
        return CampaignSubChannelLog::find()
            ->where(['is_effected' => 0])
            ->andWhere(['not', ['effect_time' => null]])
            ->andWhere(['<', 'effect_time', time()])
            ->all();
    }
}
