<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "campaign_update".
 *
 * @property integer $id
 * @property integer $campaign_id
 * @property string $action
 * @property integer $operator
 * @property integer $create_time
 * @property integer $effect_time
 *
 * @property Campaign $campaign
 * @property User $operator0
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
            [['campaign_id', 'operator', 'create_time'], 'integer'],
            [['action'], 'string', 'max' => 255],
            [['campaign_id'], 'exist', 'skipOnError' => true, 'targetClass' => Campaign::className(), 'targetAttribute' => ['campaign_id' => 'id']],
            [['operator'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['operator' => 'id']],
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
            'operator' => 'Operator',
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
    public function getOperator0()
    {
        return $this->hasOne(User::className(), ['id' => 'operator']);
    }

    public static function updateLog($campaign,$action,$effect_time){
        $model_update = new CampaignUpdate();
        $model_update->campaign_id = $campaign;
        $model_update->operator = Yii::$app->user->id;
        $model_update->create_time = time();
        $model_update->action = $action;
        $model_update->effect_time = $effect_time;
        $model_update->save();
    }
}
