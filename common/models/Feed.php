<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "feedback_advertiser_feed_log".
 *
 * @property integer $id
 * @property string $click_id
 * @property string $ch_id
 */
class Feed extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feedback_advertiser_feed_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['click_id', 'ch_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'click_id' => 'Click ID',
            'ch_id' => 'Ch ID',
        ];
    }
}
