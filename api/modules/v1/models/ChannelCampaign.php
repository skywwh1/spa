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
            "campaign_id",
            "campaign_name" => function ($model) {
                return $model->campaign->campaign_name;
            },
            "campaign_uuid",
            "pricing_mode",
            "pay_out",
            "daily_cap",
            "status" => function ($model) {
                return \ModelsUtil::getCampaignStatus($model->status);
            },
            "end_time",
            "create_time",
            "track_url" => function ($model) {
                return Url::to('@track' . $model->track_url);
            },
            "note",
        ];
    }
}