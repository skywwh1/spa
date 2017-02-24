<?php

use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CampaignSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Campaign List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div id="nav-menu" data-menu="campaign_index"></div>
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body">

                <?php // echo $this->render('_search', ['model' => $searchModel]);
                $gridColumns = [
                    'id',
                    [
                        'attribute' => 'advertiser',
                        'value' => 'advertiser0.username',
                    ],

                    [
                        'attribute' => 'campaign_name',
                        'value' => 'name',
                    ],
                    'campaign_uuid',
                    'pricing_mode',
                    'category',
                    'target_geo',
                    'platform',
                    [
                        'attribute' => 'now_payout',
                        'label' => 'Payout',
                    ],

                    'traffic_source',
                    'preview_link',

                    'daily_cap',
                    [
                        'attribute' => 'status',
                        'value' => function ($model) {
                            return ModelsUtil::getCampaignStatus($model->status);
                        },
                        'filter' => ModelsUtil::campaign_status,
                    ],
                    'note',
                ];

                $fullExportMenu = ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                    'fontAwesome' => true,
                    'showConfirmAlert' => false,
                    'target' => GridView::TARGET_BLANK,
                    'dropdownOptions' => [
                        'label' => 'Export All',
                        'class' => 'btn btn-default'
                    ]
                ]); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
//                    'headerRowOptions' => ['class' => 'kartik-sheet-style'],
//                    'filterRowOptions' => ['class' => 'kartik-sheet-style'],
//                    'autoXlFormat' => true,
//                    'showPageSummary' => true,
                    'layout' => '{toolbar}{summary} {items} {pager}',
                    'toolbar' => [
                        $fullExportMenu,
                        '{toggleData}',
                        '{export}',
                    ],
                    'export' => [
                        'fontAwesome' => true,
                        'showConfirmAlert' => false,
                        'target' => GridView::TARGET_BLANK,
                        'label' => 'Page',
                    ],
                    'pjax' => true, // pjax is set to always true for this demo
                    'pjaxSettings' => [
                        'neverTimeout' => true,
                        'options' => [
                            'id' => 'kv-unique-id-1',
                        ]
                    ],
                    'responsive' => true,
                    'hover' => true,
                    'columns' => [
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'template' => '{all}',
                            'header' => 'Action',
                            'buttons' => [
                                'all' => function ($url, $model, $key) {
                                    return '<div class="dropdown">
                                      <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Actions
                                      <span class="caret"></span></button>
                                      <ul class="dropdown-menu">

                                      <li><a data-view="0" data-url="/campaign/view?id=' . $model->id . '">View</a></li>
                                      <li><a href="/campaign/update?id=' . $model->id . '" >Update</a></li>
                                      <li><a data-pjax="0" data-view="1" data-url="/campaign-sts-update/pause?type=1&channel_id=&campaign_id=' . $model->id . '">Paused</a></li>
                                      </ul>
                                    </div>';
                                },
                            ],
                        ],
                        'id',
                        [
                            'attribute' => 'advertiser',
                            'value' => 'advertiser0.username',
//                                'pageSummary' => 'Total'
                        ],

//                        'campaign_name',
                        [
                            'attribute' => 'campaign_name',
                            'value' => 'name',
//                            'contentOptions'=>['style'=>'max-width: 100px;'] // <-- right here
                        ],
                        'campaign_uuid',
                        'pricing_mode',
//                        'indirect',
                        'category',
                        'target_geo',
//                    'device',
                        'platform',
//                        'adv_price',
                        [
                            'attribute' => 'adv_price',
//                                'pageSummary' => true
                        ],
                        'now_payout',
                        'traffic_source',
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

                        'daily_cap',
//                        'cvr',
//                        'epc',
                        [
                            'attribute' => 'status',
                            'value' => function ($model) {
                                return ModelsUtil::getCampaignStatus($model->status);
                            },
                            'filter' => ModelsUtil::campaign_status,
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

