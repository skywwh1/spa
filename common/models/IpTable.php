<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ip_table".
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 * @property string $mark
 * @property string $note
 */
class IpTable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ip_table';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'value'], 'required'],
            [['note'], 'string'],
            [['name', 'value', 'mark'], 'string', 'max' => 255],
            [['value'], 'ip'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'value' => 'Value',
            'mark' => 'Mark',
            'note' => 'Note',
        ];
    }
}
