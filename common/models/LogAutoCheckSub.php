<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "log_auto_check_sub".
 *
 * @property integer $id
 * @property integer $campaign_id
 * @property string $campaign_name
 * @property integer $channel_id
 * @property string $channel_name
 * @property string $sub_chid
 * @property string $om_email
 * @property string $match_cvr
 * @property integer $match_install
 * @property integer $installs
 * @property integer $daily_cap
 * @property string $action
 * @property integer $is_send
 * @property integer $is_read
 * @property integer $type
 * @property integer $update_time
 * @property integer $create_time
 */
class LogAutoCheckSub extends \yii\db\ActiveRecord
{
    public $pm;
    public $om;
    public $bd;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'log_auto_check_sub';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign_id', 'channel_id'], 'required'],
            [['campaign_id', 'channel_id', 'match_install', 'installs', 'daily_cap', 'is_send', 'type', 'update_time', 'create_time'], 'integer'],
            [['campaign_name', 'channel_name', 'sub_chid', 'om_email', 'action'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'campaign_id' => 'Campaign ID',
            'campaign_name' => 'Campaign Name',
            'channel_id' => 'Channel ID',
            'channel_name' => 'Channel Name',
            'sub_chid' => 'Sub Chid',
            'om_email' => 'Om Email',
            'match_cvr' => 'Match Cvr',
            'match_install' => 'Match Install',
            'installs' => 'Installs',
            'daily_cap' => 'Daily Cap',
            'action' => 'Action',
            'is_send' => 'Is Send',
            'type' => 'Type',
            'update_time' => 'Update Time',
            'create_time' => 'Create Time',
        ];
    }

    public function beforeSave($insert)
    {
        if ($insert) {
            $this->create_time = time();
            $this->update_time = time();
        } else {
            $this->update_time = time();
        }
        return parent::beforeSave($insert);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaign()
    {
        return $this->hasOne(Campaign::className(), ['id' => 'campaign_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChannel()
    {
        return $this->hasOne(Channel::className(), ['id' => 'channel_id']);
    }

    /**
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getReadStatus(){
        $query = LogAutoCheckSub::find();
        $query->alias('lac');
        // grid filtering conditions
        $query->leftJoin('channel ch','ch.id = lac.channel_id');
        $query->leftJoin('campaign camp','camp.id = lac.campaign_id');
        $query->leftJoin('advertiser adv', 'camp.advertiser = adv.id');

        if (\Yii::$app->user->can('admin')) {

        } else {
            if (\Yii::$app->user->can('pm')) {
                $query->andFilterWhere(['adv.pm' => \Yii::$app->user->id]);
            } else if (\Yii::$app->user->can('om')) {
                $query->andFilterWhere(['ch.om' => \Yii::$app->user->id]);
            } else if (\Yii::$app->user->can('bd')) {
                $query->andFilterWhere(['adv.bd' => \Yii::$app->user->id]);
            }
        }
        $data = $query->andFilterWhere(['=','is_read',0])->all();

        return $data;
    }
}
