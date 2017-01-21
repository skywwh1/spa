<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "feedback_advertiser_feed_log".
 *
 * @property integer $id
 * @property string $click_id
 * @property string $ch_id
 * @property integer $is_count
 * @property string $all_parameters
 * @property string $ip
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
            [['is_count', 'create_time', 'update_time'], 'integer'],
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
            'click_id' => 'Click ID',
            'ch_id' => 'Ch ID',
            'is_count' => 'Is Count',
            'all_parameters' => 'All Parameters',
            'ip' => 'IP',
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
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function findNeedCounts()
    {
        return static::find()->where(['is_count' => 0])->all();
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