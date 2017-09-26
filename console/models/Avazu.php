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

class Avazu
{

    public function getApiCampaign()
    {
        $apiModel = AdvertiserApi::findOne(['id' => 21]);
        $allCamps = $this->getAllCampaigns($apiModel);

        if (!empty($allCamps)) {
            $apiCams = ApiUtil::genApiCampaignAvazu($apiModel, $allCamps);
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

            $daily_cap = $model->daily_cap;
            if (empty($camp->promote_start)) {
                $camp->promote_start = time();
            }
            $camp->daily_cap = empty($daily_cap) ? 'open' : $daily_cap;
            $camp->package_name = $model->package_name;
            $camp->platform = $model->platform == '1' ? 'android' : 'ios';
            $camp->icon =  $model->icon;
            $camp->description = $model->description;
            $camp->preview_link = $model->preview_link;
            $camp->category = $model->category;
            $camp->kpi = $model->note;
            if ($model->conversion_flow == 'None') {
                $camp->kpi = 'Day 2 RR > 30%';
            }
            $camp->status = 1;
            $camp->open_type = 1;

            $camp->advertiser = $apiModel->adv_id;
            $ad = Advertiser::findOne($apiModel->adv_id);
            $camp->creator = $ad->bd;
            if (!empty($model->note)){
                $links = unserialize($model->note);
//                file_put_contents('/var/www/html/spa/console/log.txt',json_encode($links));
                foreach ($links as $item){
                    $camp->target_geo = empty($item['country'])?'not set':$item['country'];
                    $camp->adv_price = $item['payout'];
                    $camp->now_payout = $item['payout'] > 1 ? $item['payout'] * 0.9 : $item['payout'];
                    $camp->preview_link = $item['previewlink'];
                    $camp->adv_link = $item['trackinglink'];
                    if ($camp->save()) {
                        Deliver::updateStsStatusByCampaignUid($camp->campaign_uuid, $camp->status);
                    } else {
                        var_dump($model->campaign_id);
                        var_dump($camp->getErrors());
                    }
                    $liveCamps[] = $camp->campaign_uuid;
                }
            }
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
        $data_key = $apiModel->json_offers_param;
        $url = $apiModel->url;
        $curl = new Curl();
        echo "url " . $url . "\n";
        $response = $curl->get($url);
        $response = json_decode($response);
        $total = isset($response->totalnum) ? $response->totalnum : 0;
        $data = isset($response->campaigns) ? $response->campaigns : array();
        $page_size = 200;
        $page_total = $total/$page_size + ($total%$page_size == 0 ? 0 : 1);
        echo "total " . $total . "\n";
        echo "totalPage " . $page_total . "\n";

        $apiCampaigns = $data;
        if ($page_total > 1) {
            for ($i = 2; $i < $page_total; $i++) {
                $newUrl = $url . '&page=' .$i;
                $curl = new Curl();
                echo "new url " . $newUrl . "\n";
                $response = $curl->get($newUrl);
                $response = json_decode($response);
                if (!empty($response->campaigns)) {
                    $apiCampaigns = array_merge($apiCampaigns, $response->campaigns);
                }else{
                    break;
                }
            }
        }
        return $apiCampaigns;
    }

}