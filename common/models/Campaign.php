<?php

namespace common\models;

use phpDocumentor\Reflection\Types\Integer;
use SebastianBergmann\CodeCoverage\Driver\Driver;
use Yii;
use yii\db\Query;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;

/**
 * This is the model class for table "campaign".
 *
 * @property integer $id
 * @property integer $advertiser
 * @property string $campaign_name
 * @property string $campaign_uuid
 * @property string $pricing_mode
 * @property string $payout_currency
 * @property integer $promote_start
 * @property integer $promote_end
 * @property integer $effective_time
 * @property integer $adv_update_time
 * @property string $device
 * @property string $platform
 * @property string $min_version
 * @property string $max_version
 * @property string $daily_cap
 * @property string $daily_budget
 * @property string $adv_price
 * @property integer $tag
 * @property integer $direct
 * @property string $now_payout
 * @property string $target_geo
 * @property string $traffic_source
 * @property string $kpi
 * @property string $note
 * @property string $others
 * @property string $preview_link
 * @property string $icon
 * @property string $package_name
 * @property string $app_name
 * @property string $app_size
 * @property string $category
 * @property string $version
 * @property string $app_rate
 * @property string $description
 * @property string $creative_link
 * @property string $creative_type
 * @property string $creative_description
 * @property string $carriers
 * @property string $conversion_flow
 * @property integer $recommended
 * @property integer $indirect
 * @property integer $cap
 * @property integer $cvr
 * @property string $epc
 * @property string $avg_price
 * @property integer $status
 * @property integer $open_type
 * @property integer $subid_status
 * @property string $track_way
 * @property integer $third_party
 * @property string $track_link_domain
 * @property string $adv_link
 * @property integer $link_type
 * @property string $ip_blacklist
 * @property integer $is_manual
 * @property integer $creator
 * @property integer $create_time
 * @property integer $update_time
 *
 * @property ApplyCampaign[] $applyCampaigns
 * @property Channel[] $channels
 * @property Advertiser $advertiser0
 * @property User $creator0
 * @property Deliver[] $delivers
 * @property Channel[] $channels0
 * @property CampaignCreativeLink[] $campaignCreateLinks
 */
class Campaign extends \yii\db\ActiveRecord
{
    public $apply_status;
    public $is_send;

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
            [['campaign_name', 'campaign_uuid', 'adv_link', 'daily_cap', 'adv_price', 'now_payout'], 'required'],
            [['recommended', 'indirect', 'cap', 'cvr', 'tag', 'direct', 'status', 'open_type', 'subid_status', 'third_party', 'link_type', 'is_manual', 'creator', 'create_time', 'update_time'], 'integer'],
            [['adv_price', 'now_payout', 'avg_price'], 'number'],
            [['kpi', 'note', 'others', 'description'], 'string'],
            [['promote_start', 'promote_end', 'effective_time', 'adv_update_time', 'target_geo', 'advertiser', 'payout_currency', 'device', 'daily_budget', 'daily_cap', 'app_name', 'app_size', 'version', 'app_rate', 'description', 'is_send'], 'safe'],
            [['campaign_uuid', 'pricing_mode', 'platform', 'min_version', 'max_version', 'traffic_source', 'package_name', 'conversion_flow', 'epc'], 'string', 'max' => 100],
            [['campaign_name', 'preview_link', 'icon', 'category', 'creative_link', 'creative_type', 'creative_description', 'carriers', 'track_way', 'track_link_domain', 'adv_link', 'ip_blacklist'], 'string', 'max' => 255],
            [['campaign_uuid'], 'unique'],
            [['advertiser'], 'exist', 'skipOnError' => true, 'targetClass' => Advertiser::className(), 'targetAttribute' => ['advertiser' => 'id']],
            ['advertiser', 'required', 'message' => 'Advertiser does not exist'],
            ['target_geo', 'required', 'message' => 'Target Geo does not exist'],
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
            'campaign_uuid' => 'Campaign Uuid',
            'pricing_mode' => 'Pricing Mode',
            'payout_currency' => 'Payout Currency',
            'promote_start' => 'Promote Start',
            'promote_end' => 'Promote End',
            'effective_time' => 'Effective Time',
            'adv_update_time' => 'Adv Update Time',
            'device' => 'Device',
            'platform' => 'Platform',
            'min_version' => 'Min Version',
            'max_version' => 'Max Version',
            'daily_cap' => 'Daily Cap',
            'daily_budget' => 'Daily Budget',
            'adv_price' => 'Adv Price',
            'now_payout' => 'Now Payout',
            'target_geo' => 'Target Geo',
            'traffic_source' => 'Traffic Source',
            'kpi' => 'KPI',
            'note' => 'Restriction',
            'others' => 'Others',
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
            'avg_price' => 'Avg Price',
            'tag' => 'Tag',
            'direct' => 'Direct',
            'status' => 'Status',
            'open_type' => 'Open Type',
            'subid_status' => 'Subid Status',
            'track_way' => 'Track Way',
            'third_party' => 'Third Party',
            'track_link_domain' => 'Track Link Domain',
            'adv_link' => 'Adv Link',
            'link_type' => 'Link Type',
            'ip_blacklist' => 'Ip Blacklist',
            'is_manual' => 'Is Manual',
            'creator' => 'Creator',
            'create_time' => 'Create Time',
            'update_time' => 'Update Time',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApplyCampaigns()
    {
        return $this->hasMany(ApplyCampaign::className(), ['campaign_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChannels()
    {
        return $this->hasMany(Channel::className(), ['id' => 'channel_id'])->viaTable('apply_campaign', ['campaign_id' => 'id']);
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
    public function getDelivers()
    {
        return $this->hasMany(Deliver::className(), ['campaign_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getChannels0()
    {
        return $this->hasMany(Channel::className(), ['id' => 'channel_id'])->viaTable('campaign_channel_log', ['campaign_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCreativeLinks()
    {
        return $this->hasMany(Deliver::className(), ['campaign_id' => 'id']);
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

    public static function getCampaignsByUuidMultiple($uuid)
    {
//        $query = static::find();
//        $query->select("")
        $data = static::find()->select(['id', 'CONCAT(id,"-",campaign_uuid) campaign_uuid'])->where(['like', 'campaign_uuid', $uuid])->orWhere(['like', 'id', $uuid])->andWhere(['status' => 1])->limit(20)->all();
        $out['results'] = array_values($data);
        return Json::encode($out);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->create_time = time();
                $this->update_time = time();
                if (empty($this->creator)) {
                    if (isset(Yii::$app->user)) {
                        $this->creator = Yii::$app->user->identity->getId();
                    } else {
                        $this->creator = 1;
                    }
                }
            } else {
                $this->update_time = time();
            }

            return true;

        } else {
            return false;
        }
    }

    /**
     * @param $uuid
     * @return Campaign
     */
    public static function findByUuid($uuid)
    {
        return Campaign::findOne(['campaign_uuid' => $uuid]);
    }

    public function isApply($campaign_id, $channel_id)
    {
        $deliver = Deliver::findIdentity($campaign_id, $channel_id);
        if (isset($deliver)) {
            $this->apply_status = 2;
            return true;
        }
        $apply = ApplyCampaign::findIdentify($campaign_id, $channel_id);
        if (isset($apply)) {
            $this->apply_status = $apply->status;
            return true;
        }
        return false;

    }

    /**
     * @param Integer $id
     * @return Campaign
     */
    public static function findById($id)
    {
        return static::findOne($id);
    }

    /**
     * 查出需要停止的单子
     * @return array|Campaign[]
     */
    public static function getNeedPause()
    {
        return Campaign::find()
            ->where(['status' => 1])
            ->andWhere(['not', ['promote_end' => null]])
            ->andWhere(['<', 'promote_end', time()])
            ->all();
    }

    public function getName()
    {
        $str = strip_tags($this->campaign_name);
        $len = mb_strlen($str);
        return mb_substr($str, 0, 20, 'utf-8') . (($len > 20) ? '...' : '');
    }

    public function getGeo()
    {
        $str = strip_tags($this->target_geo);
        $len = mb_strlen($str);
        return mb_substr($str, 0, 20, 'utf-8') . (($len > 10) ? '...' : '');
    }

    /**
     * @param $adv_id
     * @return array|Campaign[]
     */
    public static function findAllByAdv($adv_id)
    {
        return static::find()->where(['advertiser' => $adv_id])->all();
    }
//    public function afterSave($insert,$changedAttributes){
//        parent::afterSave($insert,$changedAttributes);
//        CreativeLink::updateCreativeLink($this->creative_link,$this->id);
//    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCampaignCreateLinks()
    {
        return $this->hasMany(CampaignCreativeLink::className(), ['campaign_id' => 'id']);
    }

}
