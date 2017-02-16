<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "v_feed_log".
 *
 * @property integer $id
 * @property string $auth_token
 * @property string $click_id
 * @property string $ch_id
 * @property integer $is_count
 */
class ViewFeedLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_feed_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'is_count'], 'integer'],
            [['auth_token'], 'string', 'max' => 32],
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
            'auth_token' => 'Auth Token',
            'click_id' => 'Click ID',
            'ch_id' => 'Ch ID',
            'is_count' => 'Is Count',
        ];
    }
}
