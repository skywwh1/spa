<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "system".
 *
 * @property integer $id
 * @property string $value
 * @property string $name
 * @property string $mark
 * @property string $note
 */
class System extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'system';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value', 'name', 'mark', 'note'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'name' => 'Name',
            'mark' => 'Mark',
            'note' => 'Note',
        ];
    }
}
