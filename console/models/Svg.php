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

class Svg
{

    public function getApiCampaign()
    {
        $apiModel = AdvertiserApi::findOne(['id' => 22]);
        $allCamps = $this->getAllCampaigns($apiModel);

        if (!empty($allCamps)) {
            $apiCams = ApiUtil::genApiCampaignNew($apiModel, $allCamps);
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
            if (strpos($model->preview_link, 'referrer')){
                $model->preview_link = explode("&referrer=",$model->preview_link)[0];
            }
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

            $camp->preview_link = $model->preview_link;
            if (strstr($model->preview_link, 'itunes')) {
                $camp->package_name = explode("id",$model->preview_link)[1];
                $camp->platform = 'ios';
            }
            if (strstr($model->preview_link, 'google')) {
                $camp->package_name = explode("id=",$camp->preview_link)[1];
                $camp->platform = 'android';
            }
            if ($model->daily_cap == '0.00'){
                $camp->daily_cap = 'open';
            }
            $camp->pricing_mode = 'cpi';
            $camp->adv_price = $model->adv_price;
            $camp->now_payout = $model->adv_price > 1 ? $model->adv_price * 0.9 : $model->adv_price;
            $camp->adv_link = $model->adv_link;
            if (empty($camp->promote_start)) {
                $camp->promote_start = time();
            }
            $camp->icon =  $model->icon;
            $camp->description = $model->description;
            $camp->kpi = 'Day 2 RR > 30%';

            if (strstr($model->category,'101') || strstr($model->category,'105')){
                $camp->traffic_source = 'Incent';
            }
            if (strstr($model->category,'103') || strstr($model->category,'107')){
                $camp->traffic_source = 'Non-Incent';
            }
            $camp->carriers = 'all';
            $camp->status = 1;
            $camp->open_type = 1;

            $camp->advertiser = $apiModel->adv_id;
            $ad = Advertiser::findOne($apiModel->adv_id);
            $camp->creator = $ad->bd;
            if (empty( $model->target_geo)){
                $camp->status = 2;
                $camp->target_geo = 'not set';
            }else {
                $camp->target_geo = $model->target_geo;
            }
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
        foreach ($all as $item) {
            if (!in_array($item->campaign_uuid, $campaigns)) {
                $item->status = 2;
                if ($item->save()) {
                    Deliver::updateStsStatusByCampaignUid($item->campaign_uuid, 2);
                }
            }
        }
        var_dump('update all clinkAD');
    }

    /**
     * @param AdvertiserApi $apiModel
     * @return array
        */
        private function getAllCampaigns($apiModel)
    {
        $url = $apiModel->url.'&filters[status][]=active';
        $options = array(
            'http' => array(
                'method'  => 'GET',
                'header'=>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n".
                    "User-Agent: Mozilla/5.0 (Windows NT 10.0; WOW64; rv:55.0) Gecko/20100101 Firefox/55.0\r\n"
            )
        );
        $context  = stream_context_create( $options );
        $result = file_get_contents( $url, false, $context );
        $result = json_decode($result);
        $response = $result->response;
        if ($response->httpStatus != 200){
            echo 'bad request!';
            return $response->errorMessage;
        }
        return $response->data;
    }

}