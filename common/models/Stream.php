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
 * @property integer $is_count
 * @property integer $create_time
 *
 * @property Channel $ch
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
            [['post_status', 'post_time', 'create_time', 'is_count',], 'integer'],
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
            'cp_uid' => 'Campaign UUID',
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
            'is_count' => 'Is Count',
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
     * @return array|\common\models\Stream[]
     */
    public static function getNeedPosts()
    {
        return static::find()->where(['post_status' => 1])->all();
    }

    /**
     * @return array|\common\models\Stream[]
     */
    public static function getCountClicks()
    {
        return static::findAll(['is_count' => 0]);
    }

    public static function getDistinctIpClick($cp_uid, $ch_id)
    {
        // returns all inactive customers
        $sql = 'SELECT distinct ip FROM feedback_channel_click_log WHERE cp_uid=:cp_uid AND ch_id=:ch_id';
        return static::findBySql($sql, ['cp_uid' => $cp_uid, 'ch_id' => $ch_id])->count();
    }

    public static function getLatestClick($channel_id)
    {
//        static::findOne();
        $aa = static::find()->where(['ch_id' => $channel_id])->orderBy('create_time DESC')->one();
        return $aa;
//        if (empty($aa)) {
//            return null;
//        }
//        return $aa[0];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCh()
    {
        return $this->hasOne(Channel::className(), ['id' => 'ch_id']);
    }
}
