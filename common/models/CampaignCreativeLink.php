<?php
/**
 * Created by PhpStorm.
 * User: ctt
 * Date: 2017/5/3
 * Time: 14:13
 */

namespace common\models;

use yii\helpers\Json;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "campaign_sts_update".
 *
 * @property integer $id
 * @property integer $campaign_id
 * @property string $creative_link
 * @property string $creative_type
 *
 * @property Campaign $campaign
 */
class CampaignCreativeLink extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'campaign_create_link';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//            [['creative_link',], 'required'],
            [['campaign_id'], 'integer'],
            [['creative_link', 'creative_type'], 'string', 'max' => 255],
            [['campaign_id'], 'exist', 'skipOnError' => true, 'targetClass' => Campaign::className(), 'targetAttribute' => ['campaign_id' => 'id']],
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
            'creative_link' => 'Creative Link',
            'creative_type' => 'Creative Type',
        ];
    }

    public static function getCreativeLinkListByName($name)
    {
        return static::find()->select(['creative_link'])->where(['like', 'creative_link', $name])->column();
    }

    /**
     * @return array
     */
    public static function getAllToArray()
    {
        //->select(['CONCAT(first_name, " ", last_name) AS value', 'CONCAT(first_name, " ", last_name) AS label', 'id as id'])
        $data = static::find()->where(['<>', 'id', 1])->all();
        $temp = array();
        if (!empty($data)) {
            foreach ($data as $k) {
                $temp[$k->domain . '-' . $k->country_regions] = $k->domain . '-' . $k->country_regions;
            }
        }
        return $temp;
    }

    public function updateCreativeLink($creative_link, $id)
    {

        if (!empty($id)) {
            if (strstr($creative_link, ',')) {
                $creative_link = explode(',', $creative_link);
                foreach ($creative_link as $name) {
                    $aLink = CampaignCreativeLink::find()->where(['creative_link' => $name, 'campaign_id' => $id])->one();
                    $aLinkCount = CampaignCreativeLink::find()->where(['creative_link' => $name, 'campaign_id' => $id])->count();

                    if (!$aLinkCount) {
                        $link = new CampaignCreativeLink();
                        $link->campaign_id = $id;
                        $link->creative_link = $name;
                        $link->save();
                    }
                }
            }
        } else {
            if (strstr($creative_link, ',')) {
                $creative_link = explode(',', $creative_link);
                $link = new CampaignCreativeLink();
                $link->campaign_id = $id;
                $link->creative_link = $creative_link;
                $link->save();
            }
        }
    }

    /**
     * @param array $models
     * @param null $attributeNames
     * @return bool
     */
    public static function validateCreativeLink($models)
    {
        $valid = true;
        /* @var $model Model */
        foreach ($models as $model) {
            $valid = $model->validate() && $valid;
        }

        return $valid;
    }

    /**
     * 数组 转 对象
     *
     * @param array $arr 数组
     * @return object
     */
    public static function array_to_object($arr)
    {
        if (gettype($arr) != 'array') {
            return;
        }
        foreach ($arr as $k => $v) {
            if (gettype($v) == 'array' || getType($v) == 'object') {
                $arr[$k] = (object)self::array_to_object($v);
            }
        }

        return (object)$arr;
    }

    /**
     * 对象 转 数组
     *
     * @param object $obj 对象
     * @return array
     */
    public static function object_to_array($obj)
    {
        $obj = (array)$obj;
        foreach ($obj as $k => $v) {
            if (gettype($v) == 'resource') {
                return;
            }
            if (gettype($v) == 'object' || gettype($v) == 'array') {
                $obj[$k] = (array)object_to_array($v);
            }
        }

        return $obj;
    }

    public static function getCampaignCreativeLinksById($campaignId)
    {
        $data = CampaignCreativeLink::find()->where(['campaign_id' => $campaignId])->all();
//        $out = [];
//        foreach ($data as $d) {
//            $out[] = ['value' => $d];
//        }
        return $data;
    }

    public static function updateCreativeLinks($oldModelsLink, $modelsLink, $campaign_id)
    {
        if (!empty($oldModelsLink)) {
            $oldHouseIDs = ArrayHelper::map($oldModelsLink, 'id', 'id');
            $deletedHouseIDs = array_diff($oldHouseIDs, array_filter(ArrayHelper::map($modelsLink, 'id', 'id')));
            if (!empty($deletedHouseIDs)) {
                CampaignCreativeLink::deleteAll(['id' => $deletedHouseIDs]);
            }
        }

        foreach ($modelsLink as $modelLink) {
            if (!empty($modelLink) && isset($modelLink->id)) {
                $ccl = CampaignCreativeLink::findOne($modelLink->id);
            }
            if (!empty($ccl)) {
                $ccl->creative_link = $modelLink->creative_link;
                $ccl->creative_type = $modelLink->creative_type;
            } else {
                if (empty($modelLink->creative_link)) {
                    continue;
                }
                $ccl = new CampaignCreativeLink();
                $ccl->campaign_id = $campaign_id;
                $ccl->creative_link = $modelLink->creative_link;
                $ccl->creative_type = $modelLink->creative_type;
            }

            if (!($flag = $ccl->save(false))) {
                break;
            }
        }
        return $flag;
    }

    public static function getCreativeLinkValue($creativeLink)
    {
        if ($creativeLink == 1) {
            $creativeLink = "banner";
        } else if ($creativeLink == 2) {
            $creativeLink = "video";
        }
        return $creativeLink;
    }

    public function getCampaign()
    {
        return $this->hasOne(Campaign::className(), ['id' => 'campaign_id']);
    }
}