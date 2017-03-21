<?php


/* @var $this yii\web\View */
use common\models\Campaign;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $searchModel common\models\ReportChannelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Channel Report';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div id="nav-menu" data-menu="report-channel"></div>
<?php echo $this->render('report_channel_search', ['model' => $searchModel]);

$columns = [
    [
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
        'pageSummary' => 'Page Total',
    ],
//                                [
//                                    'label' => 'Time(UTC+8)',
//                                    'attribute' => 'time_format',
//                                    // 'value' => 'time_format',
//                                    'filter' => false,
//                                    'pageSummary' => 'Page Total',
//                                ],
    [
        'label' => 'Channel',
        'attribute' => 'channel_name',
        'value' => 'channel_name',
        'filter' => false,
    ],
    [
        'label' => 'Campaign ID',
        'attribute' => 'campaign_id',
        'value' => 'campaign_id',
//        'filter' => false,
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
    ],
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
        'label' => 'Payout(avg)',
        'attribute' => 'pay_out',
        'value' => function ($model) {
            $model = (object)$model;
            return round($model->pay_out, 2);
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
                return round(($model->match_installs / $model->clicks) * 100, 2) . '%';

            }
            return 0;
        },
        'filter' => false,
    ],
    [
        'label' => 'ADV Price(avg)',
        'attribute' => 'adv_price',
        'value' => function ($model) {
            $model = (object)$model;
            return round($model->adv_price, 2);
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
            $revenue = $model->match_installs * $model->adv_price;
            $cost = $model->installs * $model->pay_out;
            return $revenue - $cost;
        },
        'filter' => false,
        'pageSummary' => true,
    ],
    [ //低于30%
        'attribute' => 'margin',
        'value' => function ($model) {
            $model = (object)$model;
            $revenue = $model->match_installs * $model->adv_price;
            $cost = $model->installs * $model->pay_out;
            $profit = $revenue - $cost;
            $margin = $revenue > 0 ? round(($profit / $revenue) * 100, 2) . '%' : 0;
            return $margin;
        },
        'filter' => false,
    ],
    [
        'label' => 'OM',
        'attribute' => 'om',
        'value' => 'om',
    ],
];
if (!empty($dataProvider)) {
    ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-body">
                    <div class="campaign-log-hourly-index">


                        <?php echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'showPageSummary' => true,
                            'layout' => '{toolbar}{summary} {items} {pager}',
                            'toolbar' => [
                                '{toggleData}',
                            ],
                            'columns' => $columns,
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>