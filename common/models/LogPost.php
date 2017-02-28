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
 * @property string $pay_out
 * @property string $discount
 * @property integer $daily_cap
 * @property string $post_link
 * @property integer $post_time
 * @property integer $post_status
 * @property integer $create_time
 */
class LogPost extends \yii\db\ActiveRecord
{
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
            [['channel_id', 'campaign_id', 'daily_cap', 'post_time', 'post_status', 'create_time'], 'integer'],
            [['pay_out', 'discount'], 'number'],
            [['post_link'], 'string'],
            [['click_uuid', 'click_id'], 'string', 'max' => 255],
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
            'pay_out' => 'Pay Out',
            'discount' => 'Discount',
            'daily_cap' => 'Daily Cap',
            'post_link' => 'Post Link',
            'post_time' => 'Post Time',
            'post_status' => 'Post Status',
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
}
