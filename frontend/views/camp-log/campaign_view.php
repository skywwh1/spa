<?php

use common\models\Category;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Campaign */

$this->title = $model->campaign_name;
$this->params['breadcrumbs'][] = ['label' => 'Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="campaign-view">

    <h3><?= Html::encode($this->title) ?></h3>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'campaign_name',
            //'tag',
//            'campaign_uuid',
            // 'pricing_mode',
            [
                'attribute' => 'pricing_mode',
                'value' => ModelsUtil::getValue(ModelsUtil::pricing_mode, $model->pricing_mode),
            ],
            'promote_start',
            'promote_end',
//            'end_time:datetime',
//            'device',
            [
                'attribute' => 'platform',
                'value' => ModelsUtil::getPlatform($model->platform),
            ],
//            'daily_cap',
//            'open_cap',
//            'adv_price',
//            'now_payout',
            'target_geo',
            'traffic_source',
//            [
//                'attribute' => 'traffic_source',
//                'value' => ModelsUtil::getTrafficeSource($model->traffic_source),
//            ],
            'kpi',
            'note:text',
            'others',
            'preview_link:url',
//            'icon',
//            'package_name',
//            'app_name',
//            'app_size',
            'category',
//            'version',
//            'app_rate',
            'description',
            'creative_link:ntext',
            //'creative_type',
//            [
//                'attribute' => 'creative_type',
//                'value' => ModelsUtil::getCreateType($model->creative_type),
//            ],
//            'carriers',
//            'conversion_flow',
//            'recommended',
//            'indirect',
//            'status',
//            'open_type',
//            'subid_status',
//            'track_way',
//            'third_party',
//            'track_link_domain',
//            'adv_link',
//            'ip_blacklist',
        ],
    ]) ?>

</div>
