<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "campaign_api_status_log".
 *
 * @property integer $id
 * @property integer $campaign_id
 * @property integer $status
 *
 * @property Campaign $campaign
 */
class CampaignApiStatusLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'campaign_api_status_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign_id'], 'required'],
            [['campaign_id', 'status'], 'integer'],
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
            'status' => 'Status',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaign()
    {
        return $this->hasOne(Campaign::className(), ['id' => 'campaign_id']);
    }
}
