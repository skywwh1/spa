<?php
/**
 * Created by PhpStorm.
 * User: Iven.Wu
 * Date: 2017-02-10
 * Time: 10:59
 */

namespace console\controllers;


use common\models\AdvertiserApi;
use common\models\ApiCampaign;
use common\models\Campaign;
use common\utility\ApiUtil;
use linslin\yii2\curl\Curl;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

class ApiController extends Controller
{

    public function actionGetHeadway()
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
        $data = $response->$data_key;
        $camps = ApiUtil::genApiCampaigns($apiModel, $data);
        //ApiCampaign::deleteAll(['adv_id'=>$apiModel->adv_id]);
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
            $old->save();
            var_dump($item->getErrors());
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
        $camp->campaign_name = $model->campaign_name;
        $camp->platform = strtolower($model->platform);
        $camp->adv_price = $model->adv_price;
        $camp->now_payout = $model->adv_price;
        $camp->payout_currency = $model->payout_currency;
        $camp->daily_budget = $model->daily_budget;
        $daily_cap = $model->daily_budget / $model->adv_price;
        if (isset($daily_cap)) {
            $daily_cap = intval($model->daily_budget / $model->adv_price);

        } else {
            $daily_cap = 'open';
        }
        $camp->daily_cap = $daily_cap;
        $camp->target_geo = $model->target_geo;
        $camp->adv_link = $model->adv_link;
        $camp->note = $model->note . PHP_EOL . $model->description;
        $camp->preview_link = $model->preview_link;
        $camp->status = ($model->status == 'pause') ? 2 : 1;
        return $camp;

    }
}