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
use common\models\CampaignApiStatusLog;
use common\models\Deliver;
use common\utility\ApiUtil;
use linslin\yii2\curl\Curl;

class Mobair
{

    public function getApiCampaign()
    {
        $apiModel = AdvertiserApi::findOne(['id' => 15]);
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

            if (empty($camp->campaign_name)) {
                $camp->campaign_name = $model->campaign_name;
            }

            $camp->pricing_mode = $model->pricing_mode;
            $camp->adv_price = $model->adv_price;
            $camp->now_payout = $model->adv_price > 1 ? $model->adv_price * 0.9 : $model->adv_price;
            $daily_cap = $model->daily_cap;

            if (empty($camp->promote_start)) {
                $camp->promote_start = time();
            }
            $camp->daily_cap = empty($daily_cap) ? 'open' : $daily_cap;
            $camp->target_geo = $model->target_geo;
            $adv_link = $model->adv_link;
            $camp->adv_link = str_replace('&cid=[cid]&data1=[data1]&data2=[data2]&data3=[data3]&data4=[data4]&affsub1=[affsub1]&device_id=[device_id]&gaid=[gaid]&idfa=[idfa]', '', $adv_link);
            $camp->package_name = $model->package_name;
            $camp->platform = $model->platform;
            $camp->description = $model->description;
            $camp->description = strip_tags($camp->description);
            $camp->description = str_replace('&nbsp;', '', $camp->description);
            $camp->preview_link = $model->preview_link;
            $camp->note = $model->note;
            $camp->category = $model->category;
            $camp->status = 1;
            $camp->open_type = 0;

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
                    $pause = new CampaignApiStatusLog();
                    $pause->campaign_id = $item->id;
                    $pause->save();
                    Deliver::updateStsStatusByCampaignUid($item->campaign_uuid, 2);
                }
            }
        }
        var_dump('update all Affle');
    }

    /**
     * @param AdvertiserApi $apiModel
     * @return array
     */
    private function getAllCampaigns($apiModel)
    {
        $url = $apiModel->url;
        $curl = new Curl();
        echo "url " . $url . "\n";
        $response = $curl->get($url);
        $response = json_decode($response);
//        var_dump($response->data);
//        die();
        $apiOffers = $response->ads;
        $newOffers = [];
        if(!empty($apiOffers)){
            foreach ($apiOffers as $item){

                $newOffers[]=$item;
                $creatives = '';
                if(isset($item->creatives)){
                    foreach ($item->creatives as $creative){
                        $files = $creative->files;
                        if(!empty($files)){
                            foreach ($files as $file){
                                $creatives.=$file->url.';';
                            }
                        }
                    }
                }
                $item->creatives = $creatives;
            }
        }
        return $newOffers;
    }



}