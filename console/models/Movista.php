<?php

namespace console\models;

use common\models\Advertiser;
use common\models\AdvertiserApi;
use common\models\ApiCampaign;
use common\models\Campaign;
use common\models\Deliver;
use common\utility\ApiUtil;
use linslin\yii2\curl\Curl;
use stdClass;
use yii\db\BaseActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Created by PhpStorm.
 * User: Iven.Wu
 * Date: 2017-02-27
 * Time: 10:21
 */
class Movista
{

    public function getApiCampaign()
    {
        $apis = AdvertiserApi::findOne(['id' => 4]);
        $data_key = $apis->json_offers_param;
        $url = $apis->url;
        $apis->getAttribute('key');
        $param = $apis->param;
        $param = $this->replaceValue($param, $apis); // 替换key
        $paras = explode('&', $param);
        $aa = '';
        foreach ($paras as $item) {
            $item = $this->replaceUrl($item);
            $aa .= $item . '&';
        }
        $aa = rtrim($aa, '&');
        $url .= '?' . $aa;
        $data = $this->getAllData($url);
        if (isset($data)) {
            $this->genCampaign($apis, $data);
        }
    }

    public function replaceUrl($str)
    {
        //	m=index&cb=cb7654&time={time();}&token={md5($key.md5(time(););}
        if (strpos($str, '{') && strpos($str, '}')) {
            $param = strstr($str, '=', true);  //前
            $val = strstr($str, '='); // =后
            $val = substr($val, 0, -1); //去掉后面一个
            $val = substr($val, 2, strlen($val) - 2); //去电后面两个
            $val = $this->replaceFunc($val);
            return $param . '=' . $val;
        } else {
            return $str;
        }
    }

    public function replaceFunc($str)
    {
        $fun = 'return ' . $str;
        return eval($fun); // 15
    }

    /**
     * @param $str
     * @param BaseActiveRecord $model
     * @return mixed
     */
    public function replaceValue($str, $model)
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

    private function genCampaign(AdvertiserApi $api, $data)
    {

        if (!empty($data)) {
            $apiCampaigns = ApiUtil::genApiCampaigns($api, $data);
            $liveCamps = array();
            if (!empty($apiCampaigns)) {
                $apiCams = array();
                ApiCampaign::deleteAll(['adv_id' => $api->adv_id]);
                foreach ($apiCampaigns as $apiCampaign) {
                    $apiCampaign->adv_id = $api->adv_id;
                    if ($apiCampaign->save()) {
                        $apiCams[] = $apiCampaign;
                    }
                }
//                var_dump($apiCams);
//                die();
                if (!empty($apiCams)) {
                    foreach ($apiCams as $apiCampaign) {
                        $uuid = $api->adv_id . '_' . $apiCampaign->campaign_id;
                        $campaign = Campaign::findByUuid($uuid);
                        if (empty($campaign)) {
                            $campaign = new Campaign();
                        }
                        $campaign->advertiser = $api->adv_id;
                        if (empty($campaign->campaign_name)) {
                            $campaign->campaign_name = $apiCampaign->campaign_name;
                        }
                        $campaign->campaign_uuid = $api->adv_id . '_' . $apiCampaign->campaign_id;
                        $campaign->pricing_mode = $apiCampaign->pricing_mode;
                        $campaign->payout_currency = $apiCampaign->payout_currency;
                        $campaign->promote_start = $apiCampaign->promote_start;
                        $campaign->promote_end = $apiCampaign->end_time;
                        $campaign->effective_time = $apiCampaign->effective_time;
                        $campaign->adv_update_time = $apiCampaign->adv_update_time;
                        $campaign->platform = $apiCampaign->platform;
                        $campaign->daily_cap = $apiCampaign->daily_cap;
                        $campaign->daily_budget = $apiCampaign->daily_budget;
                        $campaign->adv_price = $apiCampaign->adv_price;
                        $campaign->now_payout = $apiCampaign->adv_price > 1 ? $apiCampaign->adv_price * 0.9 : $apiCampaign->adv_price;
                        $campaign->target_geo = $apiCampaign->target_geo;
                        $campaign->target_geo = str_replace('UK', 'GB', $campaign->target_geo);
                        if (empty($campaign->traffic_source)) {
                            $campaign->traffic_source = $apiCampaign->traffic_source;
                        }
                        if (empty($campaign->note)) {
                            $campaign->note = strip_tags($apiCampaign->note);
                        }
//                        $campaign->note = strip_tags($campaign->note);
                        $campaign->preview_link = $apiCampaign->preview_link;
                        $campaign->icon = $apiCampaign->icon;
                        $campaign->package_name = $apiCampaign->package_name;
                        $campaign->app_name = $apiCampaign->app_name;
                        $campaign->app_size = $apiCampaign->app_size;
                        $campaign->category = $apiCampaign->category;
                        $campaign->version = $apiCampaign->version;
                        $campaign->app_rate = $apiCampaign->app_rate;
//                        $campaign->description = $apiCampaign->description;
                        $campaign->description = strip_tags($apiCampaign->description);
//                        $campaign->creative_link = $apiCampaign->creative_link;
                        $campaign->creative_description = $apiCampaign->creative_description;
                        if (empty($campaign->carriers)) {
                            $campaign->carriers = $apiCampaign->carriers;
                        }
                        if (empty($campaign->conversion_flow)) {

                            $campaign->conversion_flow = $apiCampaign->conversion_flow;
                        }
                        $campaign->status = $apiCampaign->status == 'running' ? 1 : 2;
                        $campaign->adv_link = $apiCampaign->adv_link;
                        $adv = Advertiser::findOne(['id' => $api->adv_id]);
                        $campaign->creator = $adv->bd;
                        $campaign->update_time = $apiCampaign->update_time;
                        $campaign->open_type = 1;
                        $campaign->save();
                        var_dump($campaign->getErrors());
                        $liveCamps[] = $campaign->campaign_uuid;
                    }
                }
                $all = Campaign::findAll(['advertiser' => $api->adv_id]);
                if (!empty($liveCamps)) {
                    $this->updateCampaignStatus($liveCamps, $all);
                }
            }
        }
    }

    private function updateCampaignStatus($campaigns, $all)
    {
//        var_dump($campaigns);
//        var_dump($all);
        foreach ($all as $item) {
            if (!in_array($item->campaign_uuid, $campaigns)) {
                if($item->is_manual){
                    continue;
                }
                $item->status = 2;
                if ($item->save()) {
                    Deliver::updateStsStatusByCampaignUid($item->campaign_uuid, 2);
                }
            } else {
                if ($item->status == 2) {
                    Deliver::updateStsStatusByCampaignUid($item->campaign_uuid, 2);
                }
            }
        }
        var_dump('Movista');
    }

    private function getAllData($url)
    {
        $offset = true;
        $all = array();
        $url_offset = $url;
        while ($offset != false) {
            $curl = new Curl();
            $response = $curl->get($url_offset);
            $response = json_decode($response);
            $data = $response->offers;
            $all = array_merge($all, $data);
            $offset = $response->offset;
            echo "offset=" . $offset . "\n";
            var_dump($offset);
            $url_offset = $url . '&offset=' . $offset;
            echo "url = " . $url_offset . "\n";
        }
        return $all;
    }
}