<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model frontend\models\CampaignChannelLog */

$this->title = $model->campaign->campaign_name . ' detail';
$this->params['breadcrumbs'][] = ['label' => 'Campaign Channel Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="myoffers"></div>
<div class="row">
    <div class="col-lg-12">
        <h3 class="page-header"> <?= Html::encode($this->title) ?></h3>
    </div>
    <!-- /.col-lg-12 -->
</div>
<div class="row">
    <div class="col-lg-10">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'campaign_id',
                'campaign.campaign_name',
//            'campaign.adv_price',
                [
                    'label' => 'Pricing Mode',
                    'value' => ModelsUtil::getPricingMode($model->pricing_mode),
                ],
                [
                    'label' => 'Traffic Source',
                    'value' => $model->campaign->traffic_source,
                ],
                'pay_out',
                'daily_cap',
//            'is_run',
                [
                    'label' => 'Running',
                    'value' => ModelsUtil::getStatus($model->is_run),
                ],
                'create_time:datetime',
//            'track_url:url',
                [
                    'label' => 'Track Url',
                    'value' => Url::to('@track' . $model->track_url),
                    'format' => 'url'
                ],
                [
                    'label' => 'Preview Link',
                    'value' => $model->campaign->preview_link,
                    'format' => 'url'
                ],
                [
                    'label' => 'Creative Link',
//                    'value' => $model->campaign->creative_link,
                    'value' => $model->creative_link,
//                    'format' => 'url'
                ],
                'campaign.geo',
                'campaign.platform',
//                'click',
//                'unique_click',
//                'install',
//                'cvr',
                'kpi',
                'note',
                'others',
            ],
        ]) ?>
        <?= Html::a('Back', Yii::$app->request->referrer, ['class' => 'btn btn-primary']);
        ?>

    </div>
</div>
