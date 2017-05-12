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

class MiDirect
{

    public function getApiCampaign()
    {
        $apiModel = AdvertiserApi::findOne(['id' => 10]);
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
            $camp->pricing_mode = 'cpi';
            $camp->adv_price = $model->adv_price;
//            if ($camp->adv_price < 0.5) {
//                continue;
//            }
            $camp->now_payout = $camp->adv_price > 1 ? $camp->adv_price * 0.9 : $camp->adv_price;
            $daily_cap = $model->daily_cap;

            if (empty($camp->promote_start)) {
                $camp->promote_start = time();
            }
            $camp->daily_cap = $daily_cap == 0 ? 'open' : $daily_cap;
            $camp->target_geo = $model->target_geo;
            $camp->adv_link = $model->adv_link;
            $camp->adv_link = str_replace('&user_id={user_id}', '', $camp->adv_link);
            $camp->package_name = $model->package_name;
            $camp->description = $model->description;
            $camp->description = strip_tags($camp->description);
            $camp->description = str_replace('&nbsp;', '', $camp->description);
            $camp->kpi = 'Day Two RR >= 30%';
            $camp->others = $model->note;
            $camp->preview_link = $model->preview_link;
            if (empty($camp->platform)) {
                if (strpos($camp->preview_link, 'play.google')) {
                    $camp->platform = 'android';
                } else if (strpos($camp->preview_link, 'apple')) {
                    $camp->platform = 'ios';
                }
            }
            $camp->category = $model->category;
            $camp->status = 1;
            $camp->open_type = 1;
            $camp->tag = 2;
            if (empty($camp->traffic_source)) {
                $camp->traffic_source = 'non-incent,no adult';
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
    private function getAllCampaigns($data)
    {
        $old_url = $data->url;
        $page = 1;
        $url = str_replace('{page}', $page, $old_url);
        $url = $this->signUrl($url, $data->key);
        $curl = new Curl();
        $response = $curl->get($url);
        var_dump($url);
        $response = json_decode($response);
        $apiCampaigns = array();
        if (isset($response->total)) {
            $apiCampaigns = $response->offers;
            $total = $response->total;
            $totalPage = $total / 50;
            var_dump($totalPage);
            var_dump(ceil($totalPage));
            $totalPage = ceil($totalPage);
            if ($totalPage >= 2) {
                for ($i = 2; $i <= $totalPage; $i++) {
                    $url = str_replace('{page}', $i, $old_url);
                    $url = $this->signUrl($url, $data->key);
                    $curl = new Curl();
                    $response = $curl->get($url);
                    $response = json_decode($response);
                    $apiCampaigns = array_merge($apiCampaigns, $response->offers);
                }
            }
        }

        return $apiCampaigns;
    }

    private function signUrl($url, $app_secret)
    {
        $sign = null;
        $params = array();
        $url_parse = parse_url($url);
        if (isset($url_parse['query'])) {
            $query_arr = explode('&', $url_parse['query']);
            if (!empty($query_arr)) {
                foreach ($query_arr as $p) {
                    if (strpos($p, '=') !== false) {
                        list($k, $v) = explode('=', $p);
                        $params[$k] = urldecode($v);
                    }
                }
            }
        }

        $str = '';
        ksort($params);
        foreach ($params as $k => $v) {
            $str .= "{$k}={$v}";
        }
        $str .= $app_secret;
        $sign = md5($str);
        return $url . "&sign={$sign}";
    }
}