<?php
/**
 * Created by PhpStorm.
 * User: iven.wu
 * Date: 2/21/2017
 * Time: 12:33 AM
 */

namespace api\modules\v1\models;


use common\models\Deliver;
use yii\helpers\Url;

class ChannelCampaign extends Deliver
{
    public function fields()
    {
        return [
            'ID' => 'campaign_id',
            'Campaign name' => function ($model) {
                return $model->campaign->campaign_name;
            },
//            'campaign_uuid',
            'OS' => function ($model) {
                return $model->campaign->platform;
            },
            'Target Geo' => function ($model) {
                return $model->campaign->target_geo;
            },
            'Payout' => 'pay_out',
            'Pricing Mode' => 'pricing_mode',
            'Daily Cap' => 'daily_cap',
            'Status' => function ($model) {
                return \ModelsUtil::getCampaignStatus($model->status);
            },
            'Created Time' => function ($model) {
                if (empty($model->create_time)) {
                    return '';
                }
                return date("Y-m-d H:i:s", $model->create_time);
            },
            'End Time' => function ($model) {
                if (empty($model->end_time)) {
                    return '';
                }
                return date("Y-m-d H:i:s", $model->end_time);
            },
            'Preview Link' => function ($model) {
                return Url::to($model->campaign->preview_link);
            },
            'Link' => function ($model) {
                return Url::to('@track' . $model->track_url);
            },
            'Conversion Flow' => function ($model) {
                return $model->campaign->conversion_flow;
            },
            'Carrier' => function ($model) {
                return $model->campaign->carriers;
            },
            'Traffic Source' => function ($model) {
                return $model->campaign->traffic_source;
            },
            'Notes' => function ($model) {
                return $model->kpi . $model->note . $model->others;
            },
            'Package Name' => function ($model) {
                return $model->campaign->package_name;
            },
            'Creative' => function ($model) {
                return $model->campaign->campaignCreateLinks;
            }
        ];
    }
}
