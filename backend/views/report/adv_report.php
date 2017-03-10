<?php


/* @var $this yii\web\View */
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $searchModel common\models\ReportAdvSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Advertiser Report';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div id="nav-menu" data-menu="report-adv"></div>
<?php echo $this->render('adv_search', ['model' => $searchModel]);
$format = 'php:Y-m-d H:i';

if ($searchModel->type == 2) {
    $format = 'php:Y-m-d';
}
$columns = [
    [
        'label' => 'Time(UTC)',
        'attribute' => 'time',
//                                 'value' => 'time:datetime',
        'format' => ['DateTime', $format],
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
        'label' => 'ADV',
        'attribute' => 'adv_name',
        'value' => 'adv_name',
        'filter' => false,
    ],
    [
        'label' => 'BD',
        'attribute' => 'bd',
        'value' => 'bd',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'campaign_name',
        'value' => function ($data) {
            if (isset($data->campaign_name)) {
                return Html::tag('div', $data->campaign->name, ['data-toggle' => 'tooltip', 'data-placement' => 'left', 'title' => $data->campaign_name, 'style' => 'cursor:default;']);
            } else {
                return '';
            }
        },
        'width' => '60px',
        'format' => 'raw',
    ],
    [
        'label' => 'Channel',
        'attribute' => 'channel_name',
        'value' => 'channel_name',
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
            if ($model->clicks > 0) {

                return round($model->installs / $model->clicks, 4);
            }
            return 0;
        },
        'filter' => false,
    ],

    [
        'label' => 'Payout(avg)',
        'attribute' => 'pay_out',
        'value' => 'pay_out',
        'filter' => false,
    ],
    [
        'attribute' => 'cost',
        'value' => function ($model) {
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
            if ($model->clicks > 0) {

                return round($model->match_installs / $model->clicks, 4);

            }
            return 0;
        },
        'filter' => false,
    ],
    [
        'label' => 'ADV Price(avg)',
        'attribute' => 'adv_price',
        'value' => 'adv_price',
        'filter' => false,
    ],
    [
        'attribute' => 'revenue',
        'value' => function ($model) {
            return $model->match_installs * $model->adv_price;
        },
        'filter' => false,
        'pageSummary' => true,
    ],

    [
        'attribute' => 'def',
        'value' => function ($model) {
            return $model->match_installs - $model->installs;
        },
        'filter' => false,
        'pageSummary' => true,
    ],

    [
        'attribute' => 'deduction_percent',
        'value' => function ($model) {
            if ($model->match_installs > 0) {
                return round((($model->match_installs - $model->installs) / $model->match_installs), 4);
            }
            return 0;
        },
        'filter' => false,
    ],

    [
        'attribute' => 'profit',
        'value' => function ($model) {
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
            $revenue = $model->match_installs * $model->adv_price;
            $cost = $model->installs * $model->pay_out;
            $profit = $revenue - $cost;
            $margin = $revenue > 0 ? round(($profit / $revenue), 4) : 0;
            return $margin;
        },
        'filter' => false,
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