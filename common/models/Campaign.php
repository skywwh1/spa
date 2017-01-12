<?php

namespace common\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "campaign".
 *
 * @property integer $id
 * @property integer $advertiser
 * @property string $campaign_name
 * @property string $tag
 * @property string $campaign_uuid
 * @property integer $pricing_model
 * @property integer $promote_start
 * @property integer $promote_end
 * @property integer $end_time
 * @property integer $device
 * @property integer $platform
 * @property integer $budget
 * @property integer $open_budget
 * @property integer $daily_cap
 * @property integer $open_cap
 * @property double $adv_price
 * @property integer $now_payout
 * @property string $target_geo
 * @property string $traffice_source
 * @property string $note
 * @property string $preview_link
 * @property integer $icon
 * @property string $package_name
 * @property string $app_name
 * @property string $app_size
 * @property string $category
 * @property string $version
 * @property string $app_rate
 * @property string $description
 * @property string $creative_link
 * @property integer $creative_type
 * @property string $creative_description
 * @property string $carriers
 * @property string $conversion_flow
 * @property integer $recommended
 * @property integer $indirect
 * @property integer $cap
 * @property integer $cvr
 * @property string $epc
 * @property integer $pm
 * @property integer $bd
 * @property integer $status
 * @property integer $open_type
 * @property integer $subid_status
 * @property integer $track_way
 * @property integer $third_party
 * @property integer $track_link_domain
 * @property string $adv_link
 * @property integer $link_type
 * @property string $other_setting
 * @property string $ip_blacklist
 * @property integer $creator
 * @property integer $create_time
 * @property integer $update_time
 *
 * @property Advertiser $advertiser0
 * @property User $creator0
 * @property CampaignChannelLog[] $campaignChannelLogs
 * @property Channel[] $channels
 */
class Campaign extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'campaign';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['campaign_name', 'campaign_uuid','adv_link','budget', 'daily_cap'], 'required'],
            [['campaign_uuid'],'unique'],
//            'promote_start', 'promote_end', 'end_time',
            [['pricing_mode', 'device', 'platform', 'budget', 'open_budget', 'daily_cap', 'open_cap', 'icon', 'creative_type', 'recommended', 'indirect', 'cap', 'cvr', 'pm', 'bd', 'status', 'open_type', 'subid_status', 'track_way', 'third_party', 'track_link_domain', 'link_type', 'creator', 'create_time', 'update_time'], 'integer'],
            [['adv_price','now_payout'], 'number'],
            [['campaign_name', 'tag', 'campaign_uuid', 'traffice_source', 'package_name', 'app_name', 'app_size', 'category', 'version', 'app_rate', 'carriers', 'conversion_flow', 'epc'], 'string', 'max' => 100],
            [['target_geo', 'note', 'preview_link', 'description', 'creative_link', 'creative_description', 'adv_link', 'other_setting', 'ip_blacklist'], 'string', 'max' => 255],
            [['advertiser'], 'exist', 'skipOnError' => true, 'targetClass' => Advertiser::className(), 'targetAttribute' => ['advertiser' => 'id']],
            ['advertiser', 'required','message'=>'Advertiser does not exist'],
            [['creator'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['creator' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'advertiser' => 'Advertiser',
            'campaign_name' => 'Campaign Name',
            'tag' => 'Tag',
            'campaign_uuid' => 'Campaign Uuid',
            'pricing_model' => 'Pricing Model',
            'promote_start' => 'Promote Start',
            'promote_end' => 'Promote End',
            'end_time' => 'End Time',
            'device' => 'Device',
            'platform' => 'Platform',
            'budget' => 'Budget',
            'open_budget' => 'Open Budget',
            'daily_cap' => 'Daily Cap',
            'open_cap' => 'Open Cap',
            'adv_price' => 'Adv Price',
            'now_payout' => 'Now Payout',
            'target_geo' => 'Target Geo',
            'traffice_source' => 'Traffice Source',
            'note' => 'Note',
            'preview_link' => 'Preview Link',
            'icon' => 'Icon',
            'package_name' => 'Package Name',
            'app_name' => 'App Name',
            'app_size' => 'App Size',
            'category' => 'Category',
            'version' => 'Version',
            'app_rate' => 'App Rate',
            'description' => 'Description',
            'creative_link' => 'Creative Link',
            'creative_type' => 'Creative Type',
            'creative_description' => 'Creative Description',
            'carriers' => 'Carriers',
            'conversion_flow' => 'Conversion Flow',
            'recommended' => 'Recommended',
            'indirect' => 'Indirect',
            'cap' => 'Cap',
            'cvr' => 'Cvr',
            'epc' => 'Epc',
            'pm' => 'Pm',
            'bd' => 'Bd',
            'status' => 'Status',
            'open_type' => 'Open Type',
            'subid_status' => 'Subid Status',
            'track_way' => 'Track Way',
            'third_party' => 'Third Party',
            'track_link_domain' => 'Track Link Domain',
            'adv_link' => 'Adv Link',
            'link_type' => 'Link Type',
            'other_setting' => 'Other Setting',
            'ip_blacklist' => 'Ip Blacklist',
            'creator' => 'Creator',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdvertiser0()
    {
        return $this->hasOne(Advertiser::className(), ['id' => 'advertiser']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreator0()
    {
        return $this->hasOne(User::className(), ['id' => 'creator']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaignChannelLogs()
    {
        return $this->hasMany(CampaignChannelLog::className(), ['campaign_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChannels()
    {
        return $this->hasMany(Channel::className(), ['id' => 'channel_id'])->viaTable('campaign_channel_log', ['campaign_id' => 'id']);
    }

    public function getAllCampaignUuidJson()
    {
        $data = static::find()->select('campaign_uuid')->column();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d['name']];
        }
        return Json::encode($out);
    }

    public static function getCampaignsByUuid($uuid)
    {
        $data = static::find()->select("campaign_uuid")->where(['like', 'campaign_uuid', $uuid])->column();
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d];
        }
        return Json::encode($out);
    }

    public static function isExistCampaignUuid($uuid)
    {
        return Campaign::findOne(['campaign_uuid' => $uuid]);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->create_time = time();
                $this->update_time = time();
                $this->creator = Yii::$app->user->identity->getId();
            } else {
                $this->update_time = time();
            }

            return true;

        } else {
            return false;
        }
    }
}
