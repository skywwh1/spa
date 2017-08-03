<?php

use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ReportMatchInstallHourlySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $summary yii\data\ActiveDataProvider */


$this->title = 'Campaign revenue';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="report-match-install-hourly-index"></div>
<?php echo $this->render('_search', ['model' => $searchModel]);

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
$columns= [
    [
        // 'label' => 'campaign_id',
        'attribute' => 'campaign_id',
        'value' => 'campaign_id',
    ],

    [
        // 'label' => 'advertiser_id',
        'attribute' => 'advertiser_id',
        'value' => 'advertiser_id',
    ],
    [
        // 'label' => 'installs',
        'attribute' => 'installs',
        'value' => 'installs',
    ],
    [
        // 'label' => 'installs_in',
        'attribute' => 'installs_in',
        'value' => 'installs_in',
    ],
    [
        'label' => 'revenue',
        'attribute' => 'revenue',
        'value' => 'revenue',
    ],
    //[
    // 'label' => 'update_time',
    // 'attribute' => 'update_time',
    // 'value' => 'update_time:datetime',
    // ],
    //[
    // 'label' => 'create_time',
    // 'attribute' => 'create_time',
    // 'value' => 'create_time:datetime',
    // ],

];
if (!empty($searchModel->type)) {
    array_unshift($columns, $time_row);
} else {
//    unset($columns[2]);
//    array_pop($columns);
}

?>

<div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
                <div class="report-match-install-hourly-index">
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
                                'attribute' => 'installs',
                                'pageSummary' => true,
                                'filter' => false,
                            ],
                            [
                                'attribute' => 'installs_in',
                                'pageSummary' => true,
                                'filter' => false,
                            ],

                            [
                                'attribute' => 'revenue',
                                'filter' => false,
                                'pageSummary' => true,
                            ],
                        ],
                    ]); ?>


                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => $columns,
                    ]); ?>
                </div>
            </div>
        </div>
    </div>