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
class Yeahmobi
{
    public function getApiCampaign()
    {
        $apiModel = AdvertiserApi::findOne(['id' => 6]);
        $data_key = $apiModel->json_offers_param;
        $ios_url = $apiModel->url . '&filters[type][$eq]=ios';
        $android_url = $apiModel->url . '&filters[type][$eq]=android';
        $ios = array();
        $android = array();
        $ios = $this->genCampaigns($ios_url, $apiModel);
        $android = $this->genCampaigns($android_url, $apiModel);

        $all = array_merge($ios, $android);
        if (!empty($all)) {
            $this->transferApiModel($apiModel, $all);
        }
        var_dump(count($all));
        die();
    }

    private function transferApiModel($apiModel, $apiCampaigns)
    {
        ApiCampaign::deleteAll(['adv_id' => $apiModel->adv_id]);
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
            $camp->campaign_name = $model->campaign_name;
            $camp->campaign_name = str_replace('App Download- ', '', $camp->campaign_name);
            $camp->campaign_name = str_replace('App Download - ', '', $camp->campaign_name);
            $camp->campaign_name = str_replace('App Download -', '', $camp->campaign_name);
            $len = strpos($camp->campaign_name, 'Private');
            if (!empty($aa)) {
                $camp->campaign_name = substr($camp->campaign_name, 0, $len);
            }
            $camp->platform = $model->platform;
            $camp->pricing_mode = 'cpi';
            $camp->adv_price = $model->adv_price;
            $camp->now_payout = $model->adv_price > 1 ? $model->adv_price * 0.9 : $model->adv_price;
            $daily_cap = $model->daily_cap;
            if ($daily_cap == -1) {
                $daily_cap = 'open';
            }
            if (empty($camp->promote_start)) {
                $camp->promote_start = time();
            }
            $camp->daily_cap = $daily_cap;
            $camp->target_geo = $model->target_geo;
            $camp->adv_link = $model->adv_link;
            $camp->note = $model->description . PHP_EOL . $model->note;
            $camp->note = strip_tags($camp->note);
            $camp->preview_link = $model->preview_link;
            $camp->status = 1;
            $camp->open_type = 1;
            $camp->advertiser = $apiModel->adv_id;
            $ad = Advertiser::findOne($apiModel->adv_id);
            $camp->creator = $ad->bd;
            $camp->save();
            var_dump($camp->getErrors());
        }
    }

    private function genCampaigns($url, AdvertiserApi $apis)
    {
        $curl = new Curl();
        $curl->get($url);
        $response = $curl->response;
        if ($response == false) {
            echo "cannot get the url";
            return null;
        }
        $response = json_decode($response);
        $data = $response->data;
        $records = $data->data;
        $camps = array();
        foreach ($records as $id => $cam) {
            $cam->id = $id;
            $camps[] = $cam;
        }
        $apiCamps = ApiUtil::genApiCampaigns($apis, $camps);
        return $apiCamps;
    }

}