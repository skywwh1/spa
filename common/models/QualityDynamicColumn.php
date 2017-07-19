<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "quality_dynamic_column".
 * @property integer $id
 * @property integer $campaign_id
 * @property integer $channel_id
 * @property string $sub_channel
 * @property integer $time
 * @property string $name
 * @property string $value
 */
class QualityDynamicColumn extends \yii\db\ActiveRecord
{
    public $channel_name;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'quality_dynamic_column';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['sub_channel'], 'string', 'max' => 255],
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
            'time' => 'Time',
            'name' => 'Name',
            'value' => 'Value',
        ];
    }

    /**
     * @param $campaign_id
     * @param $channel_id
     * @param $sub_channel_id
     * @param $timestamp
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getDynamicColByDate($campaign_id, $channel_id, $sub_channel_id, $timestamp){
        return static::find()->andFilterWhere(['campaign_id' => $campaign_id, 'channel_id' => $channel_id,
            'sub_channel' => $sub_channel_id, 'time' => $timestamp])->one();
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
