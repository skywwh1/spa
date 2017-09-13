<?php
/**
 * Created by PhpStorm.
 * User: iven
 * Date: 2017/9/13
 * Time: 17:13
 */

namespace console\models;


use common\models\Advertiser;
use common\models\AdvertiserApi;
use common\models\ApiCampaign;
use common\models\Campaign;
use common\models\CampaignApiStatusLog;
use common\models\Deliver;
use common\utility\ApiUtil;
use linslin\yii2\curl\Curl;

class ADMobGeek
{

    public function getApiCampaign()
    {
        $apiModel = AdvertiserApi::findOne(['id' => 18]);
        $allCamps = $this->getAllCampaigns($apiModel);
        $apiCams = ApiUtil::genApiCampaigns($apiModel, $allCamps);
        $this->transferApiModel($apiModel, $apiCams);
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
            if (empty($camp->campaign_name)) {
                $camp->campaign_name = $model->campaign_name;
            }

            if ($model->pricing_mode == 1){
                $camp->pricing_mode = 'cpi';
            }else if ($model->pricing_mode == 2){
                $camp->pricing_mode = 'cpa';
            }else {
                $camp->pricing_mode = 'cps';
            }
            $camp->adv_price = $model->adv_price;
            $camp->now_payout = $camp->adv_price > 1 ? $camp->adv_price * 0.9 : $camp->adv_price;
            $daily_cap = $model->daily_cap;

            if (empty($camp->promote_start)) {
                $camp->promote_start = time();
            }
            $camp->daily_cap = $daily_cap == 0 ? 'open' : $daily_cap;
            $camp->target_geo = $model->target_geo;
            $camp->adv_link = $model->adv_link;
            $camp->package_name = $model->package_name;
            $camp->description = $model->description;
            $camp->description = strip_tags($camp->description);
            $camp->description = str_replace('&nbsp;', '', $camp->description);
            $camp->kpi = $model->note;
            $camp->others = $model->note;
            $camp->preview_link = $model->preview_link;
            if ($model->platform == 1){
                $camp->platform = 'ios';
            }else if ($model->pricing_mode == 2){
                $camp->platform = 'android';
            }else {
                $camp->platform = 'web';
            }
            $camp->category = $model->category;
            $camp->status = 1;
            $camp->open_type = 0;
            $camp->tag = 2;
            if ($model->traffic_source == 0) {
                $camp->traffic_source = 'non-incent';
            }else {
                $camp->traffic_source = 'incent';
            }
            if (!empty($model->creative_link)) {
                $cr = explode(';', $model->creative_link);
                foreach ($cr as $item) {
                    if (empty($item))
                        continue;
                    if (strpos($item, 'url:') !== false) {
                        $camp->creative_link = str_replace('url:', '', $item);
                        break;
                    }
                }
            }

            $camp->advertiser = $apiModel->adv_id;
            $ad = Advertiser::findOne($apiModel->adv_id);
            $camp->creator = $ad->bd;
            if ($camp->save()) {
                Deliver::updateStsStatusByCampaignUid($camp->campaign_uuid, $camp->status);
            } else {
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
//                    $pause = new CampaignApiStatusLog();
//                    $pause->campaign_id = $item->id;
//                    $pause->save();
                    Deliver::updateStsStatusByCampaignUid($item->campaign_uuid, 2);
                }
            }
        }
        var_dump('update all Npost');
    }

    /**
     * @param AdvertiserApi $data
     * @return array
     */
    private function getAllCampaigns($apiModel)
    {
        $url = $apiModel->url;
        $curl = new Curl();
        echo "url " . $url . "\n";
        $response = $curl->get($url);
        $response = json_decode($response);
//        var_dump($response->offers);
//        die();
        $apiOffers = $response->offers;
        $newOffers = [];
        if(!empty($apiOffers)){
            foreach ($apiOffers as $item){
                $newOffers[]=$item;
                $creatives = '';
                var_dump($item);
                if(isset($item->creatives)){
                    foreach ($item->creatives as $creative){
                        var_dump($creative);
                        if(!empty($creative)){
                            $creatives.=$creative->url.';';
                        }
                    }
                }
                $item->creatives = $creatives;
            }
        }
        return $newOffers;
    }
}