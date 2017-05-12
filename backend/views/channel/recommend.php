<?php

use common\models\TrafficSource;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CampaignSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $channel_id int */

$this->title = 'Recommend List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div id="nav-menu" data-menu="my_channels"></div>
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body">

                <?= Html::button('Select', ['class' => 'btn btn-primary', 'id' => 'recommend-channel-btn', 'data-url' => '/channel/get-recommend?id=' . $channel_id]) ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'id' => 'recommend-channel-grid',
                    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
//                    'headerRowOptions' => ['class' => 'kartik-sheet-style'],
//                    'filterRowOptions' => ['class' => 'kartik-sheet-style'],
//                    'autoXlFormat' => true,
//                    'showPageSummary' => true,
                    'layout' => '{summary} {items} {pager}',
//                    'pjax' => true, // pjax is set to always true for this demo
//                    'pjaxSettings' => [
//                        'neverTimeout' => true,
//                        'options' => [
//                            'id' => 'kv-unique-id-1',
//                        ]
//                    ],
                    'responsive' => true,
                    'hover' => true,
                    'columns' => [
                        [
                            'class' => 'yii\grid\CheckboxColumn', 'checkboxOptions' => function ($model) {
                            return ['value' => $model->id];
                        },
                        ],
                        'id',
                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'campaign_name',
                            'value' => function ($data) {
                                return Html::tag('div', $data->name, ['data-toggle' => 'tooltip', 'data-placement' => 'left', 'title' => $data->campaign_name, 'data-delay' => '{"show":0, "hide":3000}', 'style' => 'cursor:default;']);
                            },
                            'width' => '60px',
                            'format' => 'raw',
                        ],
                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'target_geo',
                            'value' => function ($data) {
                                return Html::tag('div', $data->geo, ['data-toggle' => 'tooltip', 'data-placement' => 'left', 'title' => $data->target_geo, 'data-delay' => '{"show":0, "hide":5000}', 'style' => 'cursor:default;']);
                            },
                            'width' => '60px',
                            'format' => 'raw',
                        ],
//                    'device',
                        'platform',
//                        'adv_price',
                        'now_payout',
                        'daily_cap',
                        [
                            'attribute' => 'traffic_source',
                            'value' => 'traffic_source',
                            'filter' => TrafficSource::find()
                                ->select(['name', 'value'])
                                ->orderBy('id')
                                ->indexBy('value')
                                ->column(),
                        ],
                        // 'traffic_source',
                        // 'note',
//                        'preview_link',
                        // 'icon',
                        // 'package_name',
                        // 'app_name',
                        // 'app_size',

                        // 'version',
                        // 'app_rate',
                        // 'description',
                        // 'creative_link',
                        // 'creative_type',
                        // 'creative_description',
                        // 'carriers',
                        // 'conversion_flow',
                        // 'recommended',

//                        'cvr',
//                        'epc',
                        [
                            'attribute' => 'tag',
                            'value' => function ($model) {
                                return ModelsUtil::getCampaignTag($model->tag);
                            },
                            'filter' => ModelsUtil::campaign_tag,
                            'contentOptions' => function ($model) {
                                if ($model->tag == 3) {
                                    return ['class' => 'bg-danger'];
                                } else if ($model->tag == 2) {
                                    return ['class' => 'bg-warning'];

                                } else if ($model->tag == 4) {
                                    return ['class' => 'bg-info'];
                                } else {
                                    return ['class' => 'bg-success'];
                                }
                            }
                        ],
                        [
                            'attribute' => 'direct',
                            'value' => function ($model) {
                                return ModelsUtil::getCampaignDirect($model->direct);
                            },
                            'filter' => ModelsUtil::campaign_direct,
//                            'contentOptions' => function ($model) {
//                                if ($model->tag == 3) {
//                                    return ['class' => 'bg-danger'];
//                                } else if ($model->tag == 2) {
//                                    return ['class' => 'bg-warning'];
//                                } else {
//                                    return ['class' => 'bg-success'];
//                                }
//                            }
                        ],
                        [
                            'attribute' => 'advertiser',
                            'value' => 'advertiser0.username',
//                                'pageSummary' => 'Total'
                        ],
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerJsFile(
    '@web/js/campaign.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>
<?php Modal::begin([
    'id' => 'campaign-modal',
    'size' => 'modal-lg',
//    'header' =>'00',
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false,
    ],
]);
echo '<div id="campaign-detail-content"></div>';
Modal::end(); ?>

<?php Modal::begin([
    'id' => 'campaign-update-modal',
    'size' => 'modal-sm',
//    'header' =>'00',
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false,
    ],
]);

echo '<div id="campaign-update-content"></div>';

Modal::end(); ?>
