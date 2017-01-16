<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "feedback_channel_click_log".
 *
 * @property integer $id
 * @property string $click_uuid
 * @property string $click_id
 * @property string $cp_uid
 * @property string $ch_id
 * @property string $pl
 * @property string $tx_id
 * @property string $all_parameters
 * @property string $ip
 * @property string $redirect
 * @property string $browser
 * @property string $browser_type
 * @property string $post_link
 * @property integer $is_post
 * @property integer $create_time
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
            [['click_uuid', 'cp_uid', 'ch_id'], 'required'],
            [['is_post', 'create_time'], 'integer'],
            [['click_uuid', 'click_id', 'cp_uid', 'ch_id', 'pl', 'tx_id', 'all_parameters', 'ip', 'redirect', 'browser', 'browser_type', 'post_link'], 'string', 'max' => 255],
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
            'pl' => 'Pl',
            'tx_id' => 'Tx ID',
            'all_parameters' => 'All Parameters',
            'ip' => 'Ip',
            'redirect' => 'Redirect',
            'browser' => 'Browser',
            'browser_type' => 'Browser Type',
            'post_link' => 'Post Link',
            'is_post' => 'Is Post',
            'create_time' => 'Create Time',
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
}
