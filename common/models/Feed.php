<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "feedback_advertiser_feed_log".
 *
 * @property integer $id
 * @property string $auth_token
 * @property string $click_id
 * @property string $ch_id
 * @property integer $is_count
 * @property string $all_parameters
 * @property string $ip
 * @property integer $ip_long
 * @property string $host_name
 * @property integer $create_time
 * @property integer $update_time
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
            [['is_count', 'ip_long', 'create_time', 'update_time'], 'integer'],
            [['auth_token'], 'safe'],
            [['click_id', 'ch_id', 'all_parameters', 'ip', 'host_name'], 'string', 'max' => 255],
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
            'all_parameters' => 'All Parameters',
            'ip' => 'IP',
            'ip_long' => 'Ip Long',
            'host_name' => 'Host Name',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }


    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->create_time = time();
                $this->ip_long = ip2long($this->ip);
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return array|Feed[]
     */
    public static function findNeedCounts()
    {
        return static::find()->where(['is_count' => 0])->orderBy('id Desc')->indexBy('id')->limit(100000)->all();
    }

    public static function getOneByClickId($clickId)
    {
        return static::findOne(['click_id' => $clickId]);
    }

    public static function findIdentify($id)
    {
        return self::findOne(['id' => $id]);
    }
}
