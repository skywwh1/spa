<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "system".
 *
 * @property integer $id
 * @property string $value
 * @property string $name
 * @property string $post_parameter
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
            [['name'], 'required'],
            [['post_parameter'], 'string'],
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
            'post_parameter' => 'Post Parameter',
            'mark' => 'Mark',
            'note' => 'Note',
        ];
    }

    /**
     * @param $value
     * @return null|string
     */
    public static function getName($value)
    {
        $model = static::findOne(['id' => $value]);
        if (!empty($model)) {
            return $model->name;
        } else {
            return null;
        }
    }
}
