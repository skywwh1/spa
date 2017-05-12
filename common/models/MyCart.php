<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mycart".
 *
 * @property integer $id
 * @property integer $campaign_id
 * @property string $campaign_name
 * @property string $target_geo
 * @property string $platform
 * @property string $payout
 * @property string $daily_cap
 * @property string $traffic_source
 * @property integer $tag
 * @property integer $direct
 * @property integer $advertiser
 * @property string $preview_link
 *
 * @property Advertiser $advertiser0
 * @property Campaign $campaign
 */
class MyCart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'my_cart';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'campaign_id', 'campaign_name'], 'required'],
            [['id', 'campaign_id', 'tag', 'direct', 'advertiser'], 'integer'],
            [['campaign_name', 'target_geo','preview_link'], 'string', 'max' => 255],
            [['platform', 'payout', 'daily_cap', 'traffic_source'], 'string', 'max' => 100],
            [['advertiser'], 'exist', 'skipOnError' => true, 'targetClass' => Advertiser::className(), 'targetAttribute' => ['advertiser' => 'id']],
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
            'campaign_name' => 'Campaign Name',
            'target_geo' => 'Target Geo',
            'platform' => 'Platform',
            'payout' => 'Payout Currency',
            'daily_cap' => 'Daily Cap',
            'traffic_source' => 'Traffic Source',
            'tag' => 'Tag',
            'direct' => 'Direct',
            'advertiser' => 'Advertiser',
            'preview_link' => 'Preview Link',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertiser0()
    {
        return $this->hasOne(Advertiser::className(), ['id' => 'advertiser']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaign()
    {
        return $this->hasOne(Campaign::className(), ['id' => 'campaign_id']);
    }
}
