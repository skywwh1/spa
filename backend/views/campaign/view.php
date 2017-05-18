<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Campaign */
/* @var $model common\models\Campaign */

$this->title = $model->campaign_name;
$this->params['breadcrumbs'][] = ['label' => 'Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        //'advertiser',
        [
            'attribute' => 'advertiser',
            'value' => $model->advertiser0->username,
        ],
        'campaign_name',
        //'tag',
        'campaign_uuid',
        'pricing_mode',
        'promote_start:datetime',
        'promote_end:datetime',
        'effective_time:datetime',
        'adv_update_time:datetime',
        'device',
        'platform',
        'min_version',
        'max_version',
        'daily_cap',
        'adv_price',
        'now_payout',
        'target_geo',
        //   [
        //      'attribute' => 'target_geo',
        //       'value' => $model->targetGeo->domain,
        //    ],
        'traffic_source',
//                        [
//                            'attribute' => 'traffic_source',
//                            'value' => ModelsUtil::getTrafficeSource($model->traffic_source),
//                        ],
        'kpi:ntext',
        'note:ntext',
        'others:ntext',
        'preview_link:url',
        'icon',
        'package_name',
        'app_name',
        'app_size',
        'category',
        'version',
        'app_rate',
        'description',
        'creative_link:ntext',
        //'creative_type',
//        [
//            'attribute' => 'creative_type',
//            'value' => ModelsUtil::getCreateType($model->creative_type),
//        ],
        'carriers',
        'conversion_flow',
        'recommended',
        'indirect',
        'cap',
        'cvr',
        'epc',
        'avg_price',
//                        'status',
        [
            'attribute' => 'tag',
            'value' => ModelsUtil::getCampaignTag($model->tag),
        ],
        [
            'attribute' => 'status',
            'value' => ModelsUtil::getCampaignStatus($model->status),
        ],
        [
            'attribute' => 'open_type',
            'value' => ModelsUtil::getOpenType($model->open_type),

        ],
        'subid_status',
        'track_way',
        'third_party',
        'track_link_domain',
        'adv_link:url',
        'link_type',
        'ip_blacklist',
//            'creator0->username',
        [
            'attribute' => 'creator',
            'value' => $model->creator0->username,
        ],
        'create_time:datetime',
        'update_time:datetime',
    ],
]) ?>

