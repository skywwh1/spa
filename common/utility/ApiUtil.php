<?php
/**
 * Created by PhpStorm.
 * User: iven.wu
 * Date: 2/4/2017
 * Time: 6:49 PM
 */

namespace common\utility;


use common\models\AdvertiserApi;
use common\models\ApiCampaign;
use common\models\ApiCampaigns;
use common\models\Campaign;
use common\models\CampaignApiStatusLog;
use common\models\Deliver;
use linslin\yii2\curl\Curl;
use yii\db\BaseActiveRecord;
use yii\helpers\ArrayHelper;

class ApiUtil
{

    public static function genUrl($model)
    {
        $url = $model->url;
        $param = $model->param;
        $param = static::replaceValue($param, $model); // 替换key
        $paras = explode('&', $param);
        $aa = '';
        foreach ($paras as $item) {
            $item = static::replaceUrl($item);
            $aa .= $item . '&';
        }
        $aa = rtrim($aa, '&');
        $url .= '?' . $aa;
        //echo $url;
        return $url;
    }

    public static function replaceUrl($str)
    {
        //	m=index&cb=cb7654&time={time();}&token={md5("key".md5(time());}
        if (strpos($str, '{') && strpos($str, '}')) {
            $param = strstr($str, '=', true);  //前
            $val = strstr($str, '='); // =后
            $val = substr($val, 0, -1); //去掉后面一个
            $val = substr($val, 2, strlen($val) - 2); //去电后面两个
            $val = static::replaceFunc($val);
            return $param . '=' . $val;
        } else {
            return $str;
        }
    }

    public static function replaceFunc($str)
    {
        $fun = 'return ' . $str;
        return eval($fun); // 15
    }

    /**
     * @param $str
     * @param BaseActiveRecord $model
     * @return mixed
     */
    public static function replaceValue($str, $model)
    {
        if (strpos($str, '"')) {
            $vs = explode('"', $str);
            foreach ($vs as $item) {
                if ($model->getAttribute($item)) {
                    $str = str_replace($item, $model->getAttribute($item), $str);
                }
            }
        }
        return $str;
    }

    /**
     * @param AdvertiserApi $apis
     * @return Campaign[] $camps
     */
    public static function genCampaigns($apis)
    {
        $url = static::genUrl($apis);
        $curl = new Curl();
        $response = $curl->get($url);
        $camps = array();
        if (json_decode($response)) {
            $data = json_decode($response);
            foreach ($data as $k => $v) {
                if ($k == $apis->json_offers_param) {
                    foreach ($v as $item) { //循环json里面的offers
                        $item = (array)$item;
                        $camp = new Campaign();
                        $camp_attrs = $camp->getAttributes();
                        $apis_attrs = $apis->getAttributes();
                        foreach ($apis_attrs as $api_k => $api_v) { //循环apis 的属性
                            if (array_key_exists($api_v, $item)) { //如果 json每一个offer的属性存在apis里面。
                                if (array_key_exists($api_k, $camp_attrs)) { // 并且campaign里面的属性也存在。
                                    if (is_array($item[$api_v])) {
                                        $camp->setAttribute($api_k, implode(',', $item[$api_v]));
                                    } else {
                                        $camp->setAttribute($api_k, $item[$api_v]);
                                    }
                                }
                            }
                        }
                        $camps[] = $camp;
                    }
                }
            }
        }
        return $camps;
    }

    /**
     * @param AdvertiserApi $apis
     * @param $data
     * @return \common\models\ApiCampaign[] $camps
     */
    public static function genApiCampaigns($apis, $data)
    {
        $camps = array();
        foreach ($data as $item) { //循环json里面的offers
            $item = ArrayHelper::toArray($item);
            $camp = new ApiCampaign();
            $camp_attrs = $camp->getAttributes();
            $apis_attrs = $apis->getAttributes();
            foreach ($apis_attrs as $api_k => $api_v) { //循环apis 的属性
                if (array_key_exists($api_v, $item)) { //如果 json每一个offer的属性存在apis里面。
                    if (array_key_exists($api_k, $camp_attrs)) { // 并且campaign api里面的属性也存在。
                        if (is_array($item[$api_v])) {
//                            var_dump($api_v);
//                            die();
//                            $camp->setAttribute($api_k, implode(',', $item[$api_v]));
                            $camp->setAttribute($api_k, static::arrayToString($item[$api_v]));

                        } else {
                            $camp->setAttribute($api_k, $item[$api_v]);
                        }
                    }
                }
            }
            $camps[] = $camp;
        }
//        var_dump($camps);
//        die();
        return $camps;
    }

    public static function arrayToString($array)
    {
        $string = "";
        if (isset($array)) {
            foreach ($array as $k => $v) {
                if (is_string($v)) {
                    $string = implode(',', $array);
                    return $string;
                }
                if (is_object($v)) {
                    $aa = (array)$v;
                    foreach ($aa as $i => $j) {
                        $string .= $i . ':' . $j . ';';
                    }
                }
                if(is_array($v)){
                    foreach ($v as $i => $j) {
                        $string .= $i . ':' . $j . ';';
                    }
                }
            }
        }
        return $string;
    }

    /**停止那些除了手动停止的sts和单子。
     * @param string[] $liveCampaignUuids
     * @param Campaign[] $allAdvCampaigns
     */
    public static function pauseCampaignAndSts($liveCampaignUuids, $allAdvCampaigns)
    {
        foreach ($allAdvCampaigns as $item) {
            if (!in_array($item->campaign_uuid, $liveCampaignUuids)) {
                if($item->is_manual){
                    continue;
                }
                $item->status = 2;
                if ($item->save()) {
                    $pause = new CampaignApiStatusLog();
                    $pause->campaign_id = $item->id;
                    $pause->save();
                    Deliver::updateStsStatusByCampaignUid($item->campaign_uuid, 2);
                }
            }
        }
    }

    public static function genIGAWorksCampaigns($data)
    {
        $camps = array();
        foreach ($data as $item) { //循环json里面的offers
            $item = ArrayHelper::toArray($item);
            $camp = new ApiCampaign();
            foreach ($item as $api_k => $api_v) { //循环apis 的属性
                if (!array_key_exists('app_details', $item)) {
                    continue;
                }
                if (array_key_exists('app_details', $item)) { //如果 json每一个offer的属性存在apis里面。
                    if (strcmp('app_details',$api_k)==0 && !empty($item['app_details'])){
                        $camp->campaign_name = $item['app_details']['bundle_id'];
                        $camp->package_name = $item['app_details']['bundle_id'];
                        $camp->platform = $item['app_details']['platform'];
                        $camp->app_rate = $item['app_details']['store_rating'];
                    }
                }
                if (array_key_exists('native_creatives', $item)) { //如果 json每一个offer的属性存在apis里面。
                    if (strcmp('native_creatives',$api_k)==0 && is_array($item['native_creatives'])) {
//                        var_dump($item['native_creatives']);
//                        $camp->creative_link = $item['native_creatives'][0]['click_url'];
//                        $camp->preview_link = $item['native_creatives'][0]['click_url'];
                        $camp->adv_link = $item['native_creatives'][0]['click_url'];
                    }
                }
                if (array_key_exists('campaigns', $item)) { //如果 json每一个offer的属性存在apis里面。
                    if (strcmp('campaigns',$api_k)==0 && !empty($item['campaigns'])) {
                        $camp->campaign_id = $item['campaigns']['campaign_id'];
                        $camp->target_geo = $item['campaigns']['country'];
                        $camp->adv_price = $item['campaigns']['points'];
                        $camp->status = 'active';
                    }
                }
            }
            if (!empty($camp->campaign_id))
                $camps[] = $camp;
        }
//        var_dump($camps);
//        die();
        return $camps;
    }


    public static function genApiCampaignAvazu($apis, $data)
    {
        $camps = array();
        foreach ($data as $item) { //循环json里面的offers
            $item = ArrayHelper::toArray($item);
            $camp = new ApiCampaign();
            $camp_attrs = $camp->getAttributes();
            $apis_attrs = $apis->getAttributes();
            foreach ($apis_attrs as $api_k => $api_v) { //循环apis 的属性
                if (array_key_exists($api_v, $item)) { //如果 json每一个offer的属性存在apis里面。
                    if (array_key_exists($api_k, $camp_attrs)) { // 并且campaign api里面的属性也存在。
                        if (is_array($item[$api_v])) {
                            $camp->setAttribute($api_k,  serialize($item[$api_v]));//数组转为string.方便后续将string转为数组
                        } else {
                            $camp->setAttribute($api_k, $item[$api_v]);
                        }
                    }
                }
            }
            $camps[] = $camp;
        }
        return $camps;
    }

    /**
     * @param $apis
     * @param $data
     * @return array
     */
    public static function genApiCampaignNew($apis, $data)
    {
        $camps = array();
        foreach ($data as $arr){
            $item = $arr->Offer;
            $item = ArrayHelper::toArray($item);
            $camp = new ApiCampaign();
            $camp->setAttribute('target_geo',  implode(",",array_keys(ArrayHelper::toArray($arr->Country))));//数组转为string.方便后续将string转为数组
            $camp->setAttribute('category',  implode(",",array_keys(ArrayHelper::toArray($arr->OfferCategory))));//数组转为string.方便后续将string转为数组
            $camp->setAttribute('adv_link',  $arr->TrackingLink->click_url);
            $camp_attrs = $camp->getAttributes();
            $apis_attrs = $apis->getAttributes();
            foreach ($apis_attrs as $api_k => $api_v) { //循环apis 的属性
                if (array_key_exists($api_v, $item)) { //如果 json每一个offer的属性存在apis里面。
                    if (array_key_exists($api_k, $camp_attrs)) { // 并且campaign api里面的属性也存在。
                        if (is_array($item[$api_v])) {
                            $camp->setAttribute($api_k,  serialize($item[$api_v]));//数组转为string.方便后续将string转为数组
                        } else {
                            $camp->setAttribute($api_k, $item[$api_v]);
                        }
                    }
                }
            }
            $camps[] = $camp;
        }
        return $camps;
    }

}