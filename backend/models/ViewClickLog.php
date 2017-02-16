<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "v_click_log".
 *
 * @property integer $id
 * @property string $click_uuid
 * @property string $click_id
 * @property string $cp_uid
 * @property string $ch_id
 * @property string $pay_out
 */
class ViewClickLog extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_click_log';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['click_uuid', 'cp_uid'], 'required'],
            [['pay_out'], 'number'],
            [['click_uuid', 'click_id', 'cp_uid', 'ch_id'], 'string', 'max' => 255],
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
            'cp_uid' => 'Cp Uid',
            'ch_id' => 'Ch ID',
            'pay_out' => 'Pay Out',
        ];
    }
}
