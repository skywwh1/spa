<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "config".
 *
 * @property integer $id
 * @property string $name
 * @property string $value
 */
class Config extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'config';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'string'],
            [['name'], 'string', 'max' => 255],
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
        ];
    }

    public static function findLastStaticsClick()
    {
        static::findOne(['name'=>'last_statics_click']);
    }

    public static function findLastStaticsFeed()
    {
        static::findOne(['name'=>'last_statics_feed']);
    }

    public static function findLastStaticsPost()
    {
        static::findOne(['name'=>'last_statics_Post']);
    }
}
