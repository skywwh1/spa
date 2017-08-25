<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use common\models\Campaign;
use kartik\export\ExportMenu;

/* @var $searchModel common\models\ReportCampaignSummarySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
$this->title = 'Campaign History Report';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div id="nav-menu" data-menu="report-campaign-history"></div>
<?php echo $this->render('campaign_history_search', ['model' => $searchModel]);
    $columns = [
    [
        'label' => 'Time(UTC)',
        'attribute' => 'timestamp',
        'value' => function ($model) use ($searchModel) {
            $model = (object)$model;
            $format = 'Y-m-d';
            $date = new DateTime();
            $date->setTimezone(new DateTimeZone($searchModel->time_zone));
            $date->setTimestamp($model->timestamp);
            return $date->format($format);
        },
        'filter' => false,
    ],
    [
        'label' => 'ID',
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
                return round(($model->installs / $model->clicks) * 100, 2) . '%';
            }
            return 0;
        },
        'filter' => false,
    ],

    [
        'label' => 'Payout (avg)',
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
        'label' => 'adv price (avg)',
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
        'label' => 'yesterday rev_def',
        'value' => function ($model) {
            return $model['yesterday_rev_def'];
        },
        'filter' => false,
        'pageSummary' => true,
        'contentOptions' => function ($model) {
            if ($model['yesterday_rev_def'] > 0) {
                return ['class' => 'bg-success'];
            } else {
                return ['class' => 'bg-danger'];
            }
        },
    ],
    [
        'label' => 'day_before rev_def',
        'value' => function ($model) {
            return $model['before_yesterday_rev_def'];
        },
        'filter' => false,
        'pageSummary' => true,
        'contentOptions' => function ($model) {
            if ($model['before_yesterday_rev_def'] > 0) {
                return ['class' => 'bg-success'];
            } else {
                return ['class' => 'bg-danger'];
            }
        },
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
    [
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
    'adv_name',
    [
        'attribute' => 'bd',
        'value' => 'bd',
        'label' => 'BD',
//        'filter' => false,
    ],
    [
        'attribute' => 'pm',
        'value' => 'pm',
        'label' => 'PM',
//        'filter' => false,
    ],
    [
        'attribute' => 'om',
        'value' => 'om',
        'label' => 'OM',
//        'filter' => false,
    ],
];
    ?>
    <!--<div id="nav-menu" data-menu="index"></div>-->
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-body">

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'showPageSummary' => true,
                        'layout' => '{toolbar}{summary} {items} {pager}',
                        'toolbar' => [
                            '{toggleData}',
                        ],
//                        'toggleDataOptions'=>['minCount'=>10],
                        'columns' => $columns,
                    ]); ?>
                </div>
            </div>
        </div>
    </div>