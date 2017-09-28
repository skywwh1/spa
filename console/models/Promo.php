<?php
namespace console\models;
/**
 * Created by CTT.
 * User: CTT
 * Date: 2017/9/27
 * Time: 16:45
 */
use common\models\Advertiser;
use common\models\AdvertiserApi;
use common\models\ApiCampaign;
use common\models\Campaign;
use common\models\Deliver;
use common\utility\ApiUtil;
use yii\helpers\ArrayHelper;

class Promo
{
    public function getApiCampaign()
    {
        $apiModel = AdvertiserApi::findOne(['id' => 23]);
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
            $camp->platform = $model->platform == '1' ? 'android' : 'ios';
            $camp->icon =  $model->icon;
            $camp->description = $model->description;
            $camp->preview_link = $model->preview_link;
            $camp->category = \ModelsUtil::getCategory($model->category);
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
                $links = unserialize($model->adv_price);
                foreach ($links as $item){
                    $camp->adv_price = $item['payout'];
                    $camp->now_payout = $item['payout'] > 1 ? $item['payout'] * 0.9 : $item['payout'];
                }
            }
            if (!empty($model->target_geo)){
                $links = unserialize($model->target_geo);
                $geos = [];
                foreach ($links as $item){
                    $geos[] = $item['code'];
                }
                $camp->target_geo = implode(",",$geos);
            }
            if (!empty($model->platform)){
                $links = unserialize($model->platform);
                $codes = [];
                foreach ($links as $item){
                    $codes[] = $item['system'];
                }
                $camp->target_geo = implode(",",$codes);
            }
            if (!empty($model->creative_link)){
                $links = unserialize($model->creative_link);
                $codes = [];
                foreach ($links as $item){
                    $codes[] = $item['filelink'];
                }
                $camp->creative_link = implode(",",$codes);
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
        $url = $apiModel->url;
        $options = array(
            'http' => array(
                'method'  => 'GET',
                'header'=>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n".
                    "Authorization : Basic Sm9hbm5hQHN1cGVyYWRzLmNuOmVHY01FcWV6NnZFNHQzSENQeXlZTWhfUjdlbDNIZlFQ\r\n"
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
        $apiCampaigns = $response;

        return $apiCampaigns;
    }
}