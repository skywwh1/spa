<?php


/* @var $this yii\web\View */
use common\models\Campaign;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $searchModel common\models\ReportSummarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $summary yii\data\ActiveDataProvider */
$this->title = 'Summary Report';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div id="nav-menu" data-menu="report-summary"></div>
<?php echo $this->render('report_summary_search', ['model' => $searchModel]);

$time_row = [];
//var_dump($searchModel->type);
//die();
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
        'label' => 'Campaign UUID',
        'attribute' => 'campaign_uuid',
        'value' => 'campaign_uuid',
        'filter' => false,
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
        'label' => 'ADV',
        'attribute' => 'adv_name',
        'value' => 'adv_name',
        'filter' => false,
    ],
    [
        'label' => 'Channel',
        'attribute' => 'channel_name',
        'value' => 'channel_name',
        'filter' => false,
    ],
    [
        'label' => 'PM',
        'attribute' => 'pm',
        'value' => 'pm',
        'filter' => false,
    ],
    [
        'label' => 'OM',
        'attribute' => 'om',
        'value' => 'om',
        'filter' => false,
    ],
    [
        'label' => 'BD',
        'attribute' => 'bd',
        'value' => 'bd',
        'filter' => false,
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
        'value' => 'cost',
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
];
if (!empty($searchModel->type)) {
    array_unshift($columns, $time_row);
}
if (!empty($dataProvider)) {
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-body">
                    <div class="campaign-log-hourly-index">
                        <?php echo GridView::widget([
                            'dataProvider' => $summary,
                            'layout' => '{items}',
                            'columns' => [
                                [
                                    // 'label' => 'clicks',
                                    'attribute' => 'clicks',
                                    // 'value' => 'clicks',
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
                                            return round(($model->installs / $model->clicks) * 100, 2) . '%';
                                        }
                                        return 0;
                                    },
                                    'filter' => false,
                                ],
                                [
                                    'attribute' => 'cost',
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
                                            return round(($model->match_installs / $model->clicks) * 100, 2) . '%';
                                        }
                                        return 0;
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
                        <?php echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'showPageSummary' => true,
                            'layout' => '{toolbar} {summary} {items} {pager}',
                            'toolbar' => [
                                '{export}',
                            ],
                            'columns' => $columns,
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>