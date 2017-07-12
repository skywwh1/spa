<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "apply_campaign".
 *
 * @property integer $campaign_id
 * @property integer $channel_id
 * @property integer $status
 * @property integer $create_time
 * @property integer $update_time
 * @property integer $is_read
 *
 * @property Campaign $campaign
 * @property Channel $channel
 */
class ApplyCampaign extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'apply_campaign';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign_id', 'channel_id'], 'required'],
            [['campaign_id', 'channel_id', 'status', 'create_time', 'update_time'], 'safe'],
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
            'campaign_id' => 'Campaign ID',
            'channel_id' => 'Channel ID',
            'status' => 'Status',
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

    /**
     * @param $campaign_id
     * @param $channel_id
     * @return static
     */
    public static function findIdentify($campaign_id, $channel_id)
    {
        return static::findOne(['campaign_id' => $campaign_id, 'channel_id' => $channel_id]);
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->create_time = time();
        } else {
            $this->update_time = time();
        }
        return parent::beforeSave($insert);
    }

    public static function getRecentApplying(){
//        $beginTheDayBefore=mktime(0,0,0,date('m'),date('d')-2,date('Y'));
        $data = static::find()
            ->leftJoin('channel','apply_campaign.channel_id = channel.id')
//            ->andFilterWhere(['>','apply_campaign.create_time',$beginTheDayBefore])
            ->andFilterWhere(['channel.om' =>yii::$app->user->id])
            ->andFilterWhere(['apply_campaign.status' => 1])
            ->andFilterWhere(['apply_campaign.is_read' => 0])->all();
        return $data;
    }

}
