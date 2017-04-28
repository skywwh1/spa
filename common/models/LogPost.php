<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "log_post".
 *
 * @property integer $id
 * @property string $click_uuid
 * @property string $click_id
 * @property integer $channel_id
 * @property integer $campaign_id
 * @property string $ch_subid
 * @property string $pay_out
 * @property string $discount
 * @property string $daily_cap
 * @property string $post_link
 * @property integer $post_time
 * @property integer $post_status
 * @property integer $is_redirect
 * @property integer $create_time
 * @property Campaign $campaign
 * @property Channel $channel
 */
class LogPost extends \yii\db\ActiveRecord
{
    public $advertiser_name;
    public $campaign_name;
    public $channel_name;
    public $campaign_uuid;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['click_uuid', 'channel_id', 'campaign_id'], 'required'],
            [['channel_id', 'campaign_id', 'daily_cap', 'post_time', 'post_status', 'is_redirect', 'create_time'], 'safe'],
            [['pay_out', 'discount'], 'safe'],
            [['post_link', 'advertiser_name'], 'safe'],
            [['click_uuid', 'click_id', 'ch_subid'], 'string', 'max' => 255],
            [['click_uuid'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'click_uuid' => 'Click Uuid',
            'click_id' => 'Click ID',
            'channel_id' => 'Channel ID',
            'campaign_id' => 'Campaign ID',
            'ch_subid' => 'Ch Subid',
            'pay_out' => 'Pay Out',
            'discount' => 'Discount',
            'daily_cap' => 'Daily Cap',
            'post_link' => 'Post Link',
            'post_time' => 'Post Time',
            'post_status' => 'Post Status',
            'is_redirect' => 'Is Redirect',
            'create_time' => 'Create Time',
        ];
    }

    /**
     * @return array|LogPost[]
     */
    public static function findPost()
    {
        return static::find()->where(['post_status' => 0])->indexBy('id')->limit(10000)->all();
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

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->create_time = time();
        }
        return parent::beforeSave($insert);
    }

}
