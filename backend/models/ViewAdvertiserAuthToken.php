<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "v_advertiser_auth_token".
 *
 * @property integer $id
 * @property string $auth_token
 */
class ViewAdvertiserAuthToken extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'v_advertiser_auth_token';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['auth_token'], 'string', 'max' => 32],
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
        ];
    }
}
