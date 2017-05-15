<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use common\models\Campaign;
use kartik\export\ExportMenu;

/* @var $searchModel common\models\ReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $summary yii\data\ActiveDataProvider */
$this->title = 'Campaign Report';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="report-index"></div>
<?php echo $this->render('_search', ['model' => $searchModel]);
if ($searchModel->type == 2) {
    $layout = '{summary} {items} {pager}';
} else {
    $layout = '{toolbar}{summary} {items} {pager}';
}
$time_row = [];
if (!empty($searchModel->type)) {
    $format = 'php:Y-m-d H:i';
    if ($searchModel->type == 2) {
        $format = 'php:Y-m-d';
    }
    $time_row = [
        'label' => 'Time(UTC)',
        'attribute' => 'timestamp',
        'value' => function ($model) use ($searchModel) {
            $model = (object)$model;
            $format = 'Y-m-d H:i';
            if ($searchModel->type == 2) {
                $format = 'Y-m-d';
            }
            $date = new DateTime();
            $date->setTimezone(new DateTimeZone($searchModel->time_zone));
            $date->setTimestamp($model->timestamp);
            return $date->format($format);
        },
        'filter' => false,

    ];
}
$columns = [
    [
        'label' => 'Campaign ID',
        'attribute' => 'campaign_id',
        'value' => 'campaign_id',
        'filter' => false,
        'pageSummary' => 'Page Total',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'campaign_name',
        'value' => function ($data) {
            $data = (object)$data;
            if (isset($data->campaign_name)) {
                return Html::tag('div', Campaign::findById($data->campaign_id)->getName(), ['data-toggle' => 'tooltip', 'data-placement' => 'left', 'title' => $data->campaign_name, 'style' => 'cursor:default;']);
            } else {
                return '';
            }
        },
        'width' => '60px',
        'format' => 'raw',
        'filter' => false,
    ],
    [
        'attribute' => 'channel_name',
        'value' => 'channel_name',
        'label' => 'Channel',
//        'filter' => false,
    ],
    [
        'attribute' => 'clicks',
        'filter' => false,
        'pageSummary' => true,
    ],
    [
        'attribute' => 'unique_clicks',
        'value' => 'unique_clicks',
        'filter' => false,
        'pageSummary' => true,
    ],
    [
        'attribute' => 'installs',
        'value' => 'installs',
        'filter' => false,
        'pageSummary' => true,
    ],
    [
        'attribute' => 'cvr',
        'value' => function ($model) {
            $model = (object)$model;
            if ($model->clicks > 0) {
                return round(($model->installs / $model->clicks) * 100, 2).'%';
            }
            return 0;
        },
        'filter' => false,
    ],

    [
        'label' => 'Payout(avg)',
        'attribute' => 'pay_out',
        'value' => function($model){
            $model = (object)$model;
            return round($model->pay_out,2);
        },
        'filter' => false,
    ],
    [
        'attribute' => 'cost',
        'value' => function ($model) {
            $model = (object)$model;
            return $model->installs * $model->pay_out;
        },
        'filter' => false,
        'pageSummary' => true,
    ],
    [
        'attribute' => 'match_installs',
        'value' => 'match_installs',
        'filter' => false,
        'pageSummary' => true,
    ],
    [
        'attribute' => 'match_cvr',
        'value' => function ($model) {
            $model = (object)$model;
            if ($model->clicks > 0) {
                return round(($model->match_installs / $model->clicks) * 100, 2).'%';

            }
            return 0;
        },
        'filter' => false,
    ],
    [
        'label' => 'ADV Price(avg)',
        'attribute' => 'adv_price',
        'value' => function($model){
            $model = (object)$model;
            return round($model->adv_price,2);
        },
        'filter' => false,
    ],
    [
        'attribute' => 'revenue',
        'value' => function ($model) {
            $model = (object)$model;
            return $model->match_installs * $model->adv_price;
        },
        'filter' => false,
        'pageSummary' => true,
    ],

    [
        'attribute' => 'def',
        'value' => function ($model) {
            $model = (object)$model;
            return $model->match_installs - $model->installs;
        },
        'filter' => false,
        'pageSummary' => true,
    ],

    [
        'attribute' => 'deduction_percent',
        'value' => function ($model) {
            $model = (object)$model;
            if ($model->match_installs > 0) {
                return round((($model->match_installs - $model->installs) / $model->match_installs) * 100, 2).'%';
            }
            return 0;
        },
        'filter' => false,
    ],

    [
        'attribute' => 'profit',
        'value' => function ($model) {
            $model = (object)$model;
            $revenue = $model->match_installs * $model->adv_price;
            $cost = $model->installs * $model->pay_out;
            return $revenue - $cost;
        },
        'filter' => false,
        'pageSummary' => true,
    ],
    [
        'attribute' => 'margin',
        'value' => function ($model) {
            $model = (object)$model;
            $revenue = $model->match_installs * $model->adv_price;
            $cost = $model->installs * $model->pay_out;
            $profit = $revenue - $cost;
            $margin = $revenue > 0 ? round(($profit / $revenue), 4) : 0;
            return $margin;
        },
        'filter' => false,
    ],
    [
        'attribute' => 'om',
        'value' => 'om',
        'label' => 'OM',
//        'filter' => false,
    ],
];
if (!empty($searchModel->type)) {
    array_unshift($columns, $time_row);
}
if (!empty($dataProvider)) {
?>
<!--<div id="nav-menu" data-menu="index"></div>-->
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body">
                <?= GridView::widget([
                    'dataProvider' => $summary,
                    'layout' => '{items}',
                    'columns' => [
//                        [
//                            'attribute' => 'campaign_id',
//                            'value' => 'campaign_id',
//                            'pageSummary' => 'Total',
//                            'filter' => false,
//                        ],
//                        [
//                            'attribute' => 'campaign_name',
//                            'value' => 'campaign_name',
//                            'label' => 'Campaign Name',
//                            'filter' => false,
//                        ],
                        [
                            'attribute' => 'clicks',
                            'pageSummary' => true,
                            'filter' => false,
                        ],
                        [
                            'attribute' => 'unique_clicks',
                            'pageSummary' => true,
                            'filter' => false,
                        ],
                        [
                            'attribute' => 'installs',
                            'pageSummary' => true,
                            'filter' => false,
                        ],
                        [
                            'attribute' => 'cvr',
                            'value' => function ($model) {
                                $model = (object)$model;
                                if ($model->clicks > 0) {
                                    return round(($model->installs / $model->clicks) * 100, 2) . '%';
                                }
                                return 0;
                            },
                            'filter' => false,
                        ],
                        [
                            'label' => 'Payout(avg)',
                            'attribute' => 'pay_out',
                            'value' => function ($model) {
                                $model = (object)$model;
                                return round($model->pay_out, 2);
                            },
                            'filter' => false,
                        ],
                        'cost',
                        [
                            'attribute' =>  'match_installs',
                            'pageSummary' => true,
                            'filter' => false,
                        ],

                        [
                            'attribute' => 'match_cvr',
                            'value' => function ($model) {
                                $model = (object)$model;
                                if ($model->clicks > 0) {
                                    return round(($model->match_installs / $model->clicks) * 100, 2) . '%';
                                }
                                return 0;
                            },
                            'filter' => false,
                        ],
//                        'campaign.adv_price',
                        [
                            'label' => 'ADV Price(avg)',
                            'attribute' => 'adv_price',
                            'value' => function($model){
                                $model = (object)$model;
                                return round($model->adv_price,2);
                            },
                            'filter' => false,
                        ],
                        [
                            'attribute' => 'revenue',
                            'filter' => false,
                            'pageSummary' => true,
                        ],
                        [
                            'attribute' => 'def',
                            'value' => function ($model) {
                                $model = (object)$model;
                                return $model->match_installs - $model->installs;
                            },
                            'filter' => false,
                            'pageSummary' => true,
                        ],
                        [
                            'attribute' => 'deduction_percent',
                            'value' => function ($model) {
                                $model = (object)$model;
                                if ($model->match_installs > 0) {
                                    return round((($model->match_installs - $model->installs) / $model->match_installs) * 100, 2) . '%';
                                }
                                return 0;
                            },
                            'filter' => false,
                        ],

                        [
                            'attribute' => 'profit',
                            'value' => function ($model) {
                                $model = (object)$model;

                                return $model->revenue - $model->cost;
                            },
                            'filter' => false,
                            'pageSummary' => true,
                        ],
                        [ //����30%
                            'attribute' => 'margin',
                            'value' => function ($model) {
                                $model = (object)$model;
                                $profit = $model->revenue - $model->cost;
                                $margin = $model->revenue > 0 ? round(($profit / $model->revenue) * 100, 2) . '%' : 0;
                                return $margin;
                            },
                            'filter' => false,
                            'contentOptions' => function ($model) {
                                $model = (object)$model;
                                $profit = $model->revenue - $model->cost;
                                $margin = $model->revenue > 0 ? round(($profit / $model->revenue), 2) : 0;
                                if ($margin < 0.3) {
                                    return ['class' => 'bg-danger'];
                                }
                            }
                        ],
                    ],
                ]); ?>
                <?php echo ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $columns,
                    'fontAwesome' => true,
                    'showConfirmAlert' => false,
                    'target' => GridView::TARGET_BLANK,
                    'dropdownOptions' => [
                        'label' => 'Export All',
                        'class' => 'btn btn-default'
                    ],
                    'exportConfig' => [
                        ExportMenu::FORMAT_TEXT => false,
                        ExportMenu::FORMAT_PDF => false,
                        ExportMenu::FORMAT_EXCEL_X => false,
                        ExportMenu::FORMAT_HTML => false,
                    ],
                ]);
                ?>
                <?php echo GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'showPageSummary' => true,
                    'layout' => $layout,
                    'toolbar' => [
                        '{toggleData}',
                    ],
                    'columns' => $columns,
                ]); ?>
            </div>
        </div>
    </div>
</div>
<?php } ?>