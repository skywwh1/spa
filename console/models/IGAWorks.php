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
class IGAWorks
{
    public function getApiCampaign()
    {
        $apiModel = AdvertiserApi::findOne(['id' => 17]);

        $url = 'https://trd-dsp.ad-brix.com/ncpibulk';
        $data = array(
            'token'      => '1087f1d0-9c88-4c28-a2aa-2506eacf4aa8',
            'ssp_id'    => 'SuperAds_API',
        );
        $options = array(
            'http' => array(
                'method'  => 'POST',
                'content' => json_encode( $data ),
                'header'=>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n"
            )
        );

        $context  = stream_context_create( $options );
        $result = file_get_contents( $url, false, $context );
        $response = json_decode( $result );
        if ($response === false) {
            echo "cannot get the cookies";
            return;
        }
//        $response = json_decode($response);

        if (isset($response->code) && $response->code == 500) {
            echo $response->message;
            return;
        }
////        $data = $response->$data_key;
//        var_dump($response);
//        die();
        $camps = ApiUtil::genIGAWorksCampaigns($response);

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
//            $camp->campaign_name = str_replace('MB|||', '', $camp->campaign_name);
//            $camp->campaign_name = str_replace('|M1120', '', $camp->campaign_name);
        }
        $camp->platform = strtolower($model->platform);
        $camp->pricing_mode = strtolower($model->pricing_mode);
        $camp->adv_price = $model->adv_price;
        $camp->now_payout = $model->adv_price > 1 ? $model->adv_price * 0.9 : $model->adv_price;
        $camp->payout_currency = $model->payout_currency;
        $camp->daily_budget = $model->daily_budget;
        $daily_cap =(empty($model->adv_price))?null:$model->daily_budget / $model->adv_price;
        if (!empty($daily_cap)) {
            $daily_cap = intval($model->daily_budget / $model->adv_price);
        } else {
            $daily_cap = 'open';
        }
        $camp->daily_cap = $daily_cap;
        $camp->target_geo = $model->target_geo;
        $camp->target_geo = str_replace('0:', '', $camp->target_geo);
        $camp->target_geo = str_replace(';', '', $camp->target_geo);
        $camp->target_geo = str_replace('O', '', $camp->target_geo);
        $camp->adv_link = substr($model->adv_link, 0, stripos($model->adv_link, '?'));
        if (empty($camp->note)) {
            $camp->note = $model->note . PHP_EOL . $model->description;
        }
        $camp->preview_link = $model->preview_link;
        $camp->status = ($model->status == 'active') ? 1 : 2;
        /**
         *  Carrier 默认为： all
            Conversion Flow 默认为：CPI
            Target GEO: KOR 改成 KR
            Traffic Source  默认为： Non-incent, no adult
            Package Name 设为 buddle_id
         */
        $camp->carriers = 'all';
        $camp->conversion_flow = 'CPI';
        $camp->traffic_source = 'non-incent,no adult';
        $camp->kpi = 'Day +1 Retention > 30%';
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