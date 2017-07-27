<?php

use kartik\grid\GridView;
use kartik\export\ExportMenu;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\EventReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $column_names array() */
/* @var $cols array() */
/* @var $match_cols array() */

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
$ch_sub = [];
if (!empty($searchModel->type)) {
    if ($searchModel->type == 2 || $searchModel->type == 3) {
        $format = 'php:Y-m-d';
        $time_row = [
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
        ];
    }
    if ($searchModel->type == 3 || $searchModel->type == 4) {
        $ch_sub =[
            // 'label' => 'channel_id',
            'attribute' => 'sub_channel',
            'value' => 'sub_channel',
            'filter' => false,
        ];
    }
}
$columns = [
    [
        // 'label' => 'campaign_id',
        'attribute' => 'campaign_id',
        'value' => 'campaign_id',
        'filter' => false,
    ],
    [
        // 'label' => 'channel_id',
        'attribute' => 'channel_id',
        'value' => 'channel_id',
        'filter' => false,
    ],
    [
        'attribute' => 'channel_name',
        'value' => 'channel_name',
        'filter' => false,
    ],
    'campaign_name',
    [
        'attribute' => 'installs',
        'value' => 'installs',
        'filter' => false,
        'pageSummary' => true
    ],
    [
        'attribute' => 'match_installs',
        'value' => 'match_installs',
        'filter' => false,
        'pageSummary' => true
    ],
];
if (!empty($searchModel->type) && ($searchModel->type == 3 || $searchModel->type == 4)) {
    array_unshift($columns, $ch_sub);
}
if (!empty($searchModel->type) && ($searchModel->type == 2 || $searchModel->type == 3)) {
    array_unshift($columns, $time_row);
}
foreach($cols as $k=>$value){
    $dynamic_column = [
        'label' => $k,
        'value'=> function ($model,$key,$index) use ($k,$column_names){
            if (array_key_exists($k,$column_names[$index])){
                return empty($model['installs'])?0:'('.$column_names[$index][$k].')'.round(($column_names[$index][$k]/$model['installs']*100),2).'%';
            }else{
                return '--';
            }
        },
        'pageSummary' => true
    ];
    array_push($columns,$dynamic_column);
}
foreach($cols as $k=>$value){
    $match_column = [
        'label' => $k.'-match',
        'value'=> function ($model,$key,$index) use ($k,$match_cols){
            if (array_key_exists($k,$match_cols[$index])){
//                return $match_cols[$index][$k];
                return empty($model['match_installs'])?0:'('.$match_cols[$index][$k].')'.round(($match_cols[$index][$k]/$model['match_installs']*100),2).'%';
            }else{
                return '--';
            }
        },
        'pageSummary' => true
    ];
    array_push($columns,$match_column);
}
?>
<?php
if (!empty($dataProvider)) {
    ?>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
                <div class="event-report-index">
                    <?php
//                    echo ExportMenu::widget([
//                        'dataProvider' => $dataProvider,
//                        'columns' => $columns,
//                        'fontAwesome' => true,
//                        'showConfirmAlert' => false,
//                        'target' => GridView::TARGET_BLANK,
//                        'dropdownOptions' => [
//                            'label' => 'Export All',
//                            'class' => 'btn btn-default'
//                        ],
//                        'exportConfig' => [
//                            ExportMenu::FORMAT_TEXT => false,
//                            ExportMenu::FORMAT_PDF => false,
//                            ExportMenu::FORMAT_EXCEL_X => false,
//                            ExportMenu::FORMAT_HTML => false,
//                        ],
//                    ]);
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
                        'pjax' => true, // pjax is set to always true for this demo
                        'responsive' => true,
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
<?php  } ?>