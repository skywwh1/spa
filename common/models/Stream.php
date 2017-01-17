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
 * @property integer $post_status
 * @property integer $post_time
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
            [['post_status', 'post_time', 'create_time'], 'integer'],
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
            'post_status' => 'Post Status',
            'post_time' => 'Post Time',
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

    /**
     * 0:inti ,1:need to post, 2:don`t post, 3: already post
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getNeedPosts()
    {
        return static::find()->where(['post_status' => 1])->all();
    }

    public static function isFirstPost($campaign_uuid, $channel_id)
    {
        $is = static::findOne(['ch_id' => $channel_id, 'cp_uid' => $campaign_uuid, ['or', 'post_status=1', 'post_status=3']]);
        if ($is) {
            return false;
        } else {
            return true;
        }

    }
}
