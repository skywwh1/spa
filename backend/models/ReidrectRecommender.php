<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "reidrect_recommender".
 *
 * @property string $id
 * @property integer $channel_id
 * @property integer $campaign_id
 * @property integer $redirect_to
 * @property string $redirect_name
 * @property double $cvr
 * @property double $epc
 * @property integer $status
 */
class ReidrectRecommender extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'reidrect_recommender';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channel_id', 'campaign_id', 'redirect_to', 'status'], 'integer'],
            [['cvr', 'epc'], 'number'],
            [['redirect_name'], 'string', 'max' => 100],
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
            'redirect_to' => 'Redirect To',
            'redirect_name' => 'Redirect Name',
            'cvr' => 'Cvr',
            'epc' => 'Epc',
            'status' => 'Status',
        ];
    }

    public static function getRecommendCampaign($campaignId,$channelId)
    {
        $data = ReidrectRecommender::find()
            ->select(['redirect_to id', 'CONCAT(redirect_to,"-",redirect_name,"-",cvr,"-",epc) text'])
            ->andFilterWhere(['campaign_id'=> $campaignId,'channel_id'=> $channelId])
            ->andFilterWhere(['status'=> 1])
            ->limit(50)
            ->asArray()->all();
        $data = array_merge($data);
        $data = ArrayHelper::map($data, 'id', 'text');
        return $data;
    }

}
