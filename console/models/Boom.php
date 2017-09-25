<?php
namespace console\models;
/**
 * Created by CTT.
 * User: CTT
 * Date: 2017/9/25
 * Time: 16:45
 */
use common\models\Advertiser;
use common\models\AdvertiserApi;
use common\models\ApiCampaign;
use common\models\Campaign;
use common\models\Deliver;
use common\utility\ApiUtil;
use yii\helpers\ArrayHelper;

class Boom
{
    public function getApiCampaign()
    {
        $apiModel = AdvertiserApi::findOne(['id' => 20]);
        $allCamps = $this->getAllCampaigns($apiModel);

        if (!empty($allCamps)) {
            $apiCams = $this->genCampaigns($allCamps);
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
//            var_dump(explode("id=",$model->preview_link)[1]);
//            die();
//            $camp->package_name = explode("id",$model->preview_link)[1];
            if (strpos($camp->preview_link, 'itunes')) {
                $camp->package_name = explode("id",$model->preview_link)[1];
//                $camp->platform = 'ios';
            }
            if (strpos($camp->preview_link, 'google')) {
                $camp->package_name = explode("id=",$model->preview_link)[1];
//                $camp->platform = 'android';
            }
            $camp->platform = $model->platform;
            $camp->icon =  $model->icon;
            $camp->description = $model->description;
            $camp->preview_link = $model->preview_link;
            $camp->note = $model->category;
            if (!empty($model->description)){
                $camp->kpi = $model->description;
            }else{
                $camp->kpi = 'Day+1 Retention Rate > 30%';
            }
            $camp->conversion_flow = $model->conversion_flow;
            if ($model->status == 'active'){
                $camp->status = 1;
            }else{
                $camp->status = 0;
            }
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
//        if (!empty($liveCamps)) {
//            $this->updateCampaignStatus($liveCamps, $all);
//        }

    }

    private function genCampaigns($data)
    {
        $camps = array();
        foreach ($data as $item) { //循环json里面的offers
            $item = ArrayHelper::toArray($item);
            $camp = new ApiCampaign();
            foreach ($item as $api_k => $api_v) { //循环apis 的属性
                if (strcmp('offer',$api_k)==0 && !empty($item['offer'])){
                    $camp->campaign_id = $item['offer']['id'];
                    $camp->campaign_name = $item['offer']['name'];
                    $camp->category = $item['offer']['category'];
//                    $camp->conversion_flow = $item['offer']['conversion_protocol'];
                    $camp->payout_currency = $item['offer']['currency'];
                    $camp->description = $item['offer']['description'];
                    $camp->end_time = $item['offer']['end_date'];
                    $camp->package_name = $item['offer']['offer_approval'];
                    $camp->adv_price = $item['offer']['payout'];
                    $camp->preview_link = $item['offer']['preview_url'];
                    $camp->pricing_mode = $item['offer']['pricing_type'];
                    $camp->status = $item['offer']['status'];
                    $camp->adv_link = $item['offer']['tracking_link'];
                }
                if (strcmp('offer_geo',$api_k)==0 && !empty($item['offer_geo'])){
                    $targets = $item['offer_geo']['target'];
                    $geos = [];
                    foreach ($targets as $i){
                        $geos[] = $i['country_code'];
                    }
                    $camp->target_geo = implode(',',$geos);
                }
                if (strcmp('offer_platform',$api_k)==0 && !empty($item['offer_platform'])){
                    $targets = $item['offer_platform']['target'];
                    $data = [];
                    foreach ($targets as $i){
                        $data[] = $i['system'];
                    }
                    $camp->platform = implode(',',$data);
                }
                if (strcmp('offer_cap',$api_k)==0 && !empty($item['offer_cap'])){
                    $targets = $item['offer_cap'];
                    if ($targets['cap_type'] ==2 ){
                        $camp->daily_cap = $targets['cap_conversion'];
                    }
                }
                if (strcmp('offer_creative',$api_k)==0 && !empty($item['offer_creative'])){
                    $targets = $item['offer_creative'];
                    $data = [];
                    foreach ($targets as $i){
                        $data[] = $i['url'];
                    }
                    $camp->creative_link = implode(',',$data);
                }
            }
            if (!empty($camp->campaign_id))
                $camps[] = $camp;
        }
        return $camps;
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
        $url = $apiModel->url;
        $options = array(
            'http' => array(
                'method'  => 'GET',
                'header'=>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n".
                    "Authorization : Basic Ym9zdGVyQHN1cGVyYWRzLmNuOjQ3ODIxOTRhYTlmODQ2NDNiOWZlNDUyZTJiYWM4OWU5\r\n"
            )
        );
        $context  = stream_context_create( $options );
        $result = file_get_contents( $url, false, $context );

        $response = json_decode( $result );
        if ($response === false) {
            echo "cannot get the cookies";
            return;
        }
        if (isset($response->code) && $response->code == 500) {
            echo $response->message;
            return;
        }
        $total = isset($response->data->totalRows) ? $response->data->totalRows : 0;
        $data = isset($response->data) ? $response->data : array();
        $page_total = $response->data->totalPages;
        echo "total " . $total . "\n";
        echo "totalPage " . $page_total . "\n";

        $apiCampaigns = $response->data->rowset;
        if ($page_total > 1) {
            for ($i = 2; $i < $page_total; $i++) {
                $newUrl = $url . '&offset=' .$i;
                echo "new url " . $newUrl . "\n";
                $response = file_get_contents( $url, false, $context );
                $response = json_decode($response);
                if (!empty($response->data)) {
//                    $apiCampaigns[] = $response->data->rowset;
                    $apiCampaigns = array_merge($apiCampaigns, $response->data->rowset);
                }else{
                    break;
                }
            }
        }
        return $apiCampaigns;
    }
}