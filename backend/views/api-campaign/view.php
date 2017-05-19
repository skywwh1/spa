<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\ApiCampaign */

$this->title = $model->adv_id;
$this->params['breadcrumbs'][] = ['label' => 'Api Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <div id="nav-menu" data-menu="api-campaign-view"></div>
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body">

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'adv_id',
            'adv_update_time',
            'effective_time',
            'campaign_id',
            'campaign_uuid',
            'campaign_name',
            'pricing_mode',
            'promote_start',
            'end_time',
            'platform',
            'daily_cap',
            'adv_price',
            'payout_currency',
            'daily_budget',
            'target_geo',
            'adv_link',
            'traffic_source',
            'note:ntext',
            'preview_link',
            'icon',
            'package_name',
            'app_name',
            'app_size',
            'category',
            'version',
            'app_rate',
            'description',
            'creative_link:ntext',
            'creative_type',
            'creative_description',
            'carriers',
            'conversion_flow',
            'status',
            'create_time:datetime',
            'update_time:datetime',
        ],
    ]) ?>

            </div>
        </div>
    </div>
</div
