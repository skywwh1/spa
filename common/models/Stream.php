<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "feedback_channel_click_log".
 *
 * @property integer $id
 * @property string $click_id
 * @property string $cp_uid
 * @property string $ch_id
 * @property string $pl
 * @property string $tx_id
 * @property string $ip
 */
class Stream extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'feedback_channel_click_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['click_id', 'cp_uid', 'ch_id'], 'required'],
            [['click_id', 'cp_uid', 'ch_id', 'pl', 'tx_id', 'ip'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'click_id' => 'click_id',
            'cp_uid' => 'cp_uid',
            'ch_id' => 'ch_id',
            'pl' => 'pl',
            'tx_id' => 'Tx ID',
            'ip' => 'IP',
        ];
    }
}
