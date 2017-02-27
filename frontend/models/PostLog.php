<?php

namespace frontend\models;

use Yii;

/**
 * This is the model class for table "post_log".
 *
 * @property integer $id
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
class PostLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['channel_id', 'campaign_id'], 'required'],
            [['channel_id', 'campaign_id', 'daily_cap', 'post_time', 'post_status', 'create_time'], 'integer'],
            [['pay_out', 'discount'], 'number'],
            [['post_link'], 'string'],
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
            'pay_out' => 'Pay Out',
            'discount' => 'Discount',
            'daily_cap' => 'Daily Cap',
            'post_link' => 'Post Link',
            'post_time' => 'Post Time',
            'post_status' => 'Post Status',
            'create_time' => 'Create Time',
        ];
    }
}
