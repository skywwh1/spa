<?php

namespace console\models;

use common\models\Advertiser;
use common\models\AdvertiserApi;
use common\models\ApiCampaign;
use common\models\Campaign;
use common\utility\ApiUtil;
use linslin\yii2\curl\Curl;
use yii\helpers\ArrayHelper;

/**
 * Created by PhpStorm.
 * User: Iven.Wu
 * Date: 2017-02-27
 * Time: 10:19
 */
class HeadWay
{
    public function getApiCampaign()
    {
        $apiModel = AdvertiserApi::findOne(['id' => 5]);
        $data_key = $apiModel->json_offers_param;


        $curl = new Curl();
        $curl->post('http://api.mobra.in/v1/auth/login?user=boster@superads.cn&password=Mobrain123', false);

        $headers = $curl->responseHeaders;
        $cookies = explode(';', $headers["Set-Cookie"]);
        $cook = $cookies[0];

//        var_dump($cook);


        $curl = new Curl();
        $response = $curl->setOption(
            CURLOPT_HTTPHEADER,
            array(
                "cache-control:no-cache",
                "cookie:$cook",
            )
        )->get('https://api.mobra.in/v1/campaign/feed');
        if ($response === false) {
            echo "cannot get the cookies";
            return;
        }
        $response = json_decode($response);
        if (isset($response->code) && $response->code == 500) {
            echo $response->message;
            return;
        }
        $data = $response->$data_key;
//        var_dump($data);
//        die();
        $camps = ApiUtil::genApiCampaigns($apiModel, $data);
        ApiCampaign::deleteAll(['adv_id' => $apiModel->adv_id]);
        foreach ($camps as $item) {
//            echo $apiModel->adv_id.'-';
//            echo $item->campaign_id;
            $old = ApiCampaign::findOne(['adv_id' => $apiModel->adv_id, 'campaign_id' => $item->campaign_id]);

            if (isset($old)) {
                $old->load(ArrayHelper::toArray($item));
                echo "update";
            } else {
                $old = $item;
                $old->adv_id = $apiModel->adv_id;
            }
//            var_dump($item);
            $old->save();
            var_dump($old->getErrors());
            $camp = $this->transferApiModel($old);
            $camp->advertiser = $apiModel->adv_id;
            $camp->save();
            var_dump($camp->getErrors());
        }
    }

    private function transferApiModel(ApiCampaign $model)
    {
        $uuid = $model->adv_id . '_' . $model->campaign_id;
        $camp = Campaign::findByUuid($uuid);
        if (empty($camp)) {
            $camp = new Campaign();
        }

        $camp->campaign_uuid = $uuid;
        if (empty($camp->campaign_name)) {
            $camp->campaign_name = $model->campaign_name;
            $camp->campaign_name = str_replace('MB|||', '', $camp->campaign_name);
            $camp->campaign_name = str_replace('|M1120', '', $camp->campaign_name);
        }
        $camp->platform = strtolower($model->platform);
        $camp->pricing_mode = strtolower($model->pricing_mode);
        $camp->adv_price = $model->adv_price;
        $camp->now_payout = $model->adv_price > 1 ? $model->adv_price * 0.9 : $model->adv_price;
        $camp->payout_currency = $model->payout_currency;
        $camp->daily_budget = $model->daily_budget;
        $daily_cap = $model->daily_budget / $model->adv_price;
        if (!empty($daily_cap)) {
            $daily_cap = intval($model->daily_budget / $model->adv_price);

        } else {
            $daily_cap = 'open';
        }
        $camp->daily_cap = $daily_cap;
        $camp->target_geo = $model->target_geo;
        $camp->adv_link = substr($model->adv_link, 0, stripos($model->adv_link, '?'));
        if (empty($camp->note)) {
            $camp->note = $model->note . PHP_EOL . $model->description;
        }
        $camp->preview_link = $model->preview_link;
        $camp->status = ($model->status == 'active') ? 1 : 2;
//        if (isset($model->creative_link)) {
//            $aa = explode(';', $model->creative_link);
//            $camp->creative_link = str_replace('path:', '', $aa[0]);
//            $camp->creative_type = 'banners';
//        }
        $ad = Advertiser::findOne($model->adv_id);
        $camp->creator = $ad->bd;
        return $camp;

    }
}