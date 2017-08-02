<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "campaign_update".
 *
 * @property integer $id
 * @property integer $campaign_id
 * @property string $action
 * @property integer $creator_name
 * @property integer $create_time
 * @property integer $effect_time
 *
 * @property Campaign $campaign
 */
class CampaignUpdate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'campaign_update';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign_id', 'create_time', 'effect_time'], 'integer'],
            [['action'], 'string', 'max' => 255],
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
            'action' => 'Action',
            'creator_name' => 'Creator Name',
            'create_time' => 'Create Time',
            'effect_time' => 'Effect Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaign()
    {
        return $this->hasOne(Campaign::className(), ['id' => 'campaign_id']);
    }

    public static function updateLog($campaign,$action,$effect_time){
        $model_update = new CampaignUpdate();
        $model_update->campaign_id = $campaign;
        $model_update->creator_name = Yii::$app->user->identity->username;
        $model_update->create_time = time();
        $model_update->action = $action;
        $model_update->effect_time = $effect_time;
        $model_update->save();
        var_dump($model_update->errors);
        die();
    }
}
