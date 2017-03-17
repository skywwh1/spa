<?php

namespace common\models;

use Yii;
use yii\db\Query;

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
 * @property string $ch_subid
 * @property string $gaid
 * @property string $idfa
 * @property string $site
 * @property string $adv_price
 * @property string $pay_out
 * @property string $daily_cap
 * @property string $discount
 * @property string $all_parameters
 * @property string $ip
 * @property integer $ip_long
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
            [['adv_price', 'pay_out', 'discount'], 'number'],
            [['ip_long', 'post_status', 'post_time', 'is_count', 'create_time'], 'integer'],
            [['click_uuid', 'click_id', 'cp_uid', 'ch_id', 'pl', 'tx_id', 'daily_cap', 'ch_subid', 'gaid', 'idfa', 'site', 'all_parameters', 'ip', 'redirect', 'browser', 'browser_type', 'post_link'], 'safe'],
            [['click_uuid'], 'unique'],
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
            'ch_subid' => 'Ch Subid',
            'gaid' => 'Gaid',
            'idfa' => 'Idfa',
            'site' => 'Site',
            'adv_price' => 'Adv Price',
            'pay_out' => 'Pay Out',
            'daily_cap' => 'Daily Cap',
            'discount' => 'Discount',
            'all_parameters' => 'All Parameters',
            'ip' => 'Ip',
            'ip_long' => 'Ip Long',
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
                $this->ip_long = ip2long($this->ip);
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
        return static::find()->where(['post_status' => 1])->orderBy('id Desc')->indexBy('id')->all();
    }

    /**
     * @return array|\common\models\Stream[]
     */
    public static function getCountClicks()
    {
        return static::find()->where(['is_count' => 0])->orderBy('id Asc')->indexBy('id')->limit(1000000)->all();
    }

    public static function getUpdateClicks()
    {
        $query = static::find();
        $query->alias('fc');
        $query->leftJoin('log_click lc', 'fc.click_uuid=lc.click_uuid');
        $query->where(['fc.is_count' => 0]);
        $query->orderBy('id Desc');
        $query->limit(10000);
        return $query->all();
    }

    public static function insertClicks()
    {

        $sql = 'INSERT INTO log_click (tx_id,click_uuid,click_id,channel_id,campaign_id,campaign_uuid,pl,ch_subid,gaid,idfa,site,adv_price,pay_out,discount,daily_cap,all_parameters,ip,ip_long,redirect,browser,browser_type,click_time,create_time) SELECT fc.id,fc.click_uuid,fc.click_id,fc.ch_id,ca.id camid,fc.cp_uid,fc.pl,fc.ch_subid,fc.gaid,fc.idfa,fc.site,fc.adv_price,fc.pay_out,fc.discount,fc.daily_cap,fc.all_parameters,fc.ip,fc.ip_long,fc.redirect,fc.browser,fc.browser_type,fc.create_time,fc.create_time FROM feedback_channel_click_log fc LEFT JOIN campaign ca ON fc.cp_uid = ca.campaign_uuid where fc.is_count=0 order by fc.create_time desc limit 10000';
        Yii::$app->db->createCommand($sql)->execute();

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
