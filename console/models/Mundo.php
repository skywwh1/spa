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

class Mundo
{

    public function getApiCampaign()
    {
        $apiModel = AdvertiserApi::findOne(['id' => 12]);
        $allCamps = $this->getAllCampaigns($apiModel);

        if (!empty($allCamps)) {
            $apiCams = ApiUtil::genApiCampaigns($apiModel, $allCamps);
            $this->transferApiModel($apiModel, $apiCams);
        } else {
            var_dump("error network");
        }

    }

    private function transferApiModel($apiModel, $apiCampaigns)
    {
        ApiCampaign::deleteAll(['adv_id' => $apiModel->adv_id]);
        $all = Campaign::findAllByAdv($apiModel->adv_id);
        $liveCamps = array();
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
            if (strpos($camp->campaign_name, 'CPE') !== false) {
                continue;
            }
            if (strpos($camp->campaign_name, 'CPP') !== false) {
                continue;
            }
            if (empty($camp->campaign_name)) {
                $camp->campaign_name = $model->campaign_name;
            }

            $camp->pricing_mode = 'cpi';
            $camp->adv_price = $model->adv_price;
            $camp->now_payout = $model->adv_price > 1 ? $model->adv_price * 0.9 : $model->adv_price;
            $daily_cap = $model->daily_cap;

            if (empty($camp->promote_start)) {
                $camp->promote_start = time();
            }
            $camp->daily_cap = empty($daily_cap) ? 'open' : $daily_cap;
            $camp->target_geo = $model->target_geo;
            $camp->adv_link = $model->adv_link;
            $camp->package_name = $model->package_name;
            $camp->platform = $model->platform;
            $camp->description = $model->description;
            $camp->description = strip_tags($camp->description);
            $camp->description = str_replace('&nbsp;', '', $camp->description);
            $camp->preview_link = $model->preview_link;
            $camp->note = $model->note;
            $camp->category = $model->category;
            $camp->kpi = $model->conversion_flow . ':' . $model->status;
            if ($model->conversion_flow == 'None') {
                $camp->kpi = 'Day 2 RR > 30%';
            }
            $camp->status = 1;
            $camp->open_type = 1;

            $camp->advertiser = $apiModel->adv_id;
            $ad = Advertiser::findOne($apiModel->adv_id);
            $camp->creator = $ad->bd;
            if ($camp->save()) {
                Deliver::updateStsStatusByCampaignUid($camp->campaign_uuid, $camp->status);
            } else {
                var_dump($model->campaign_id);
                var_dump($camp->getErrors());
            }
            $liveCamps[] = $camp->campaign_uuid;
        }
        if (!empty($liveCamps)) {
            $this->updateCampaignStatus($liveCamps, $all);
        }

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
        var_dump('update all Mundo');
    }

    /**
     * @param AdvertiserApi $apiModel
     * @return array
     */
    private function getAllCampaigns($apiModel)
    {
        $data_key = $apiModel->json_offers_param;
        $url = $apiModel->url;
        $curl = new Curl();
        echo "url " . $url . "\n";
        $response = $curl->get($url);
        $response = json_decode($response);
        $limit = 100;
        $total = isset($response->recordsTotal) ? $response->recordsTotal : 0;
        $data = isset($response->$data_key) ? $response->$data_key : array();
        echo "total " . $total . "\n";
//        var_dump($data);
//            die();
        $apiCampaigns = $data;
        if ($total > $limit) {
            $totalPage = ceil($total / $limit);
            echo "totalPage " . $totalPage . "\n";
            for ($i = 1; $i < $totalPage; $i++) {
                $newUrl = $url . '&skip=' . ($i * $limit);
                $curl = new Curl();
                echo "new url " . $newUrl . "\n";
                $response = $curl->get($newUrl);
                $response = json_decode($response);
                if (!empty($response->$data_key)) {
                    $apiCampaigns[] = $response->$data_key;
                }else{
                    break;
                }
            }
        }
        if (!empty($apiCampaigns)) {
            $this->genCreatives($apiCampaigns);
        }
        return $apiCampaigns;
    }


    public function genCreatives(&$apiCams)
    {
//        https://publisher-api.mm-tracking.com/creative?publisher_token=168fe8b43bc30b61f7f0e3d32899c1b1&campId=
        if (!empty($apiCams)) {
            foreach ($apiCams as $item) {
                if(!isset($item->id))
                    continue;
                $url = 'https://publisher-api.mm-tracking.com/creative?publisher_token=168fe8b43bc30b61f7f0e3d32899c1b1&campId=' . $item->id;
                echo "creative url " . $url . "\n";
                $curl = new Curl();
                $response = $curl->get($url);
                $response = json_decode($response);
                if (!empty($response)) {
                    foreach ($response as $aa) {
                        if (isset($aa->link)) {
                            if (empty($item->isp)) {
                                $item->isp = $aa->link . ';';
                            } else {
                                $item->isp .= $aa->link . ';';
                            }
                        }
                    }
                }
            }
        }
    }
}