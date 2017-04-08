<?php

namespace console\models;

use common\models\Advertiser;
use common\models\AdvertiserApi;
use common\models\ApiCampaign;
use common\models\Campaign;
use common\models\Deliver;
use common\utility\ApiUtil;
use linslin\yii2\curl\Curl;
use yii\helpers\ArrayHelper;

/**
 * Created by PhpStorm.
 * User: Iven.Wu
 * Date: 2017-02-27
 * Time: 10:19
 */
class Glispa
{
    public function getApiCampaign()
    {
        $apiModel = AdvertiserApi::findOne(['id' => 7]);
        $data_key = $apiModel->json_offers_param;
        $url = $apiModel->url;
        $curl = new Curl();

        $response = $curl->get($url);
//        var_dump($response);
        if (isset($response)) {
            $response = json_decode($response);
            $data = $response->$data_key;
            $apiCams = ApiUtil::genApiCampaigns($apiModel, $data);
            $this->transferApiModel($apiModel, $apiCams);
        }

    }

    private function transferApiModel($apiModel, $apiCampaigns)
    {
        ApiCampaign::deleteAll(['adv_id' => $apiModel->adv_id]);
        $all = Campaign::findAllByAdv($apiModel->adv_id);
        $liveCamps = array();
        foreach ($apiCampaigns as $model) {
            $model->adv_id = $apiModel->adv_id;
            $model->save();
            var_dump($model->getErrors());
            $uuid = $model->adv_id . '_' . $model->campaign_id;
            $camp = Campaign::findByUuid($uuid);
            if (empty($camp)) {
                $camp = new Campaign();
            }
            $camp->campaign_uuid = $uuid;
            if(empty($camp->campaign_name)){
                $camp->campaign_name = $model->campaign_name;
            }
            $camp->pricing_mode = 'cpi';
            $camp->adv_price = $model->adv_price;
            $camp->now_payout = $model->adv_price > 1 ? $model->adv_price * 0.9 : $model->adv_price;
            $daily_cap = $model->daily_cap;

            if (empty($camp->promote_start)) {
                $camp->promote_start = time();
            }
            $camp->daily_cap = $daily_cap;
            $camp->target_geo = $model->target_geo;
            $camp->adv_link = $model->adv_link;
            if (empty($camp->note)) {
                $camp->note = $model->description . PHP_EOL . $model->note;
            }
            if (!empty($model->preview_link) && empty($camp->preview_link)) {
                $links = explode(',', $model->preview_link);
                foreach ($links as $item) {
                    if (strpos($item, 'glispa') === false) {
                        $camp->preview_link = $item;
                    }
                }
            }
            $camp->category = $model->category;
            $camp->status = 1;
            $camp->open_type = 0;
            $camp->preview_link = str_replace('market://', 'https://play.google.com/store/apps/', $camp->preview_link);
            $camp->preview_link = str_replace('itms-apps', 'https', $camp->preview_link);
            if (strpos($camp->preview_link, 'itunes')) {
                $camp->package_name = 'id' . $model->package_name;
                $camp->platform = 'ios';
            }
            if (strpos($camp->preview_link, 'google')) {
                $camp->package_name = $model->package_name;
                $camp->platform = 'android';
            }
            $camp->advertiser = $apiModel->adv_id;
            $ad = Advertiser::findOne($apiModel->adv_id);
            $camp->creator = $ad->bd;
            if ($camp->save()) {
                Deliver::updateStsStatusByCampaignUid($camp->campaign_uuid, 1);
            }
            var_dump($camp->getErrors());
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
        var_dump('glispa');
    }

}