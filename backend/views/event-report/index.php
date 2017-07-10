<?php

use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\EventReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Event Report';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="event-report-index"></div>
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
        // 'label' => 'time',
        'attribute' => 'time',
        'value' => 'time',
        'format' => 'datetime'
    ],

    [
        // 'label' => 'campaign_id',
        'attribute' => 'campaign_id',
        'value' => 'campaign_id',
    ],
    [
        // 'label' => 'channel_id',
        'attribute' => 'channel_id',
        'value' => 'channel_id',
    ],

    [
        // 'label' => 'event',
        'attribute' => 'event',
        'value' => 'event',
    ],
    [
        'label' => 'match_total',
        'attribute' => 'match_total',
        'value' => 'match_total',
    ],
    [
        'label' => 'total',
        'attribute' => 'total',
        'value' => 'total',
    ],
    //[
    // 'label' => 'create_time',
    // 'attribute' => 'create_time',
    // 'value' => 'create_time:datetime',
    // ],


];
if (!empty($searchModel->type)) {
    array_unshift($columns, $time_row);
}

?>

<div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
                <div class="log-event-hourly-index">
                    <?php
                    echo ExportMenu::widget([
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

                    <?= GridView::widget([
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