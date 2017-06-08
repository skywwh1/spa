<?php
/**
 * Created by PhpStorm.
 * User: iven
 * Date: 2017/4/19
 * Time: 17:13
 */

namespace console\models;


use common\models\Advertiser;
use common\models\AdvertiserApi;
use common\models\ApiCampaign;
use common\models\Campaign;
use common\models\Deliver;
use common\utility\ApiUtil;
use linslin\yii2\curl\Curl;

class Nposting
{

    public function getApiCampaign()
    {
        $apiModel = AdvertiserApi::findOne(['id' => 8]);
        $data_key = $apiModel->json_offers_param;
        $url = $apiModel->url;
        $curl = new Curl();
        $curl->setOption(CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750");
        $curl->setOption(CURLOPT_COOKIE, '');
        $response = $curl->get($url);
//        var_dump($response);
        if (isset($response)) {
            $response = json_decode($response);
            $data = $response->$data_key->lists;
            $allCamps = $this->getAllCampaigns($data);
//            var_dump($data);
            $apiCams = ApiUtil::genApiCampaigns($apiModel, $allCamps);
            $this->transferApiModel($apiModel, $apiCams);
        }

    }

    private function transferApiModel($apiModel, $apiCampaigns)
    {
        ApiCampaign::deleteAll(['adv_id' => $apiModel->adv_id]);
        $all = Campaign::findAllByAdv($apiModel->adv_id);
//        $liveCamps = array();
        foreach ($apiCampaigns as $model) {
            $model->adv_id = $apiModel->adv_id;
            if (!$model->save()) {
                var_dump($model->getErrors());
            }
            $uuid = $model->adv_id . '_' . $model->campaign_id;
            $camp = Campaign::findByUuid($uuid);
            if (empty($camp)) {
                $camp = new Campaign();
            }
            $camp->campaign_uuid = $uuid;
            if (empty($camp->campaign_name)) {
                $camp->campaign_name = $model->campaign_name;
            }
            if ($model->pricing_mode == 'NCPA') {
                $camp->pricing_mode = 'cpa';
            } else {
                $camp->pricing_mode = 'cpi';
            }
//            $camp->adv_price = round($model->adv_price / 1250, 2);
            $camp->adv_price = $model->adv_price;
            $camp->now_payout = $camp->adv_price > 1 ? $camp->adv_price * 0.9 : $camp->adv_price;
            $daily_cap = $model->daily_cap;

            if (empty($camp->promote_start)) {
                $camp->promote_start = time();
            }
            $camp->daily_cap = $daily_cap;
            $camp->target_geo = 'KR';
            $camp->adv_link = $model->adv_link;
            $camp->package_name = $model->package_name;
            $camp->platform = $model->platform;
            $camp->description = $model->description;
            $camp->description = strip_tags($camp->description);
            $camp->traffic_source="non-incent,no adult";
            $camp->description = str_replace('&nbsp;', '', $camp->description);
            if (empty($camp->preview_link)) {
                if ($camp->platform == 'android') {
                    $camp->preview_link = 'https://play.google.com/store/apps/details?id=' . $camp->package_name;
                }
                if ($camp->platform == 'ios') {
                    $camp->preview_link = $camp->package_name;
                }
            }
            $camp->category = $model->category;
            if ($model->status == 'live') {
                $camp->status = 1;
            } else {
                $camp->status = 2;
            }
            $camp->open_type = 1;

            $camp->advertiser = $apiModel->adv_id;
            $ad = Advertiser::findOne($apiModel->adv_id);
            $camp->creator = $ad->bd;
            if ($camp->save()) {
                //  Deliver::updateStsStatusByCampaignUid($camp->campaign_uuid, $camp->status);
            } else {
                var_dump($camp->getErrors());
            }
//            $liveCamps[] = $camp->campaign_uuid;
        }
//        if (!empty($liveCamps)) {
//            $this->updateCampaignStatus($liveCamps, $all);
//        }

    }

    private function updateCampaignStatus($campaigns, $all)
    {
//        var_dump($campaigns);
//        var_dump($all);
        foreach ($all as $item) {
            if (!in_array($item->campaign_uuid, $campaigns)) {
                $item->status = 2;
                if ($item->save()) {
                    Deliver::updateStsStatusByCampaignUid($item->campaign_uuid, 2);
                }
            }
        }
        var_dump('update all Npost');
    }

    private function getAllCampaigns($data)
    {
        $url = "http://api.nposting.com/campaign/detail?lang=english&api_cd=885d8d8ac0e193642c5e85229972b1cd";
        $apiCampaigns = array();
        $miss = array();
        if (!empty($data)) {
            foreach ($data as $item) {
                $newUrl = $url . '&camp_id=' . $item->camp_id;
                echo $newUrl . "\n";
                $curl = new Curl();
                $curl->setOption(CURLOPT_USERAGENT, "Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/33.0.1750");
                $curl->setOption(CURLOPT_COOKIE, '');
                $response = $curl->get($newUrl);

                if (isset($response)) {
                    $response = json_decode($response);
                    $camp = $response->body->info;
                    $cc = $response->body->channels;
                    if (!empty($cc)) {
                        $camp->adv_link = $cc[0]->channel_link;
                        $apiCampaigns[] = $camp;
                    } else {
                        $miss[] = $camp->title . '-' . $camp->camp_id;
                    }
                }
            }
        }
//        die();
        var_dump($miss);
        return $apiCampaigns;
    }

}