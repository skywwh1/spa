<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\editable\Editable;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ChannelQualityReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $cols array */
/* @var $columnName array */
/* @var $campaign string */

$this->title = 'Channel Quality Reports';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div id="nav-menu" data-menu="channel-quality-report-index"></div>
<?php echo $this->render('_search', ['model' => $searchModel]);
if (!empty($cols)) {
    ?>
    <div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
                <div class="channel-quality-report-index">
                    <?php
                    $columns = [
                        [
                            'label' => 'Time',
                            'attribute' => 'timestamp',
                            'value' => 'timestamp',
                            'filter' => false,
                        ],
                        [
                            'attribute' => 'campaign_id',
                            'value' => 'campaign_id',
                            'filter' => false,
                        ],
                        [
                            'attribute' => 'campaign_name',
                            'value' => 'campaign_name',
                            'filter' => false,
                        ],
                        [
                            // 'label' => 'sub_channel',
                            'attribute' => 'sub_channel',
                            'value' => 'sub_channel',
                            'filter' => false,
                        ],
                        [
                            'attribute' => 'clicks',
                            'value' => 'clicks',
                            'filter' => false,
                        ],
                        [
                            'attribute' => 'unique_clicks',
                            'value' => 'unique_clicks',
                            'filter' => false,
                        ],
                        [
                            'attribute' => 'installs',
                            'value' => 'installs',
                            'filter' => false,
                        ],
                        [
                            'attribute' => 'cvr',
                            'value' => function ($model) {
                                $model = (object)$model;
                                if ($model->clicks > 0) {
                                    return round(($model->installs / $model->clicks) * 100, 2) . '%';
                                }
                                return "0%";
                            },
                            'filter' => false,
                        ],
                    ];
                    $data_list = $dataProvider->models;
                    $dynamic_column = [];
                        foreach($cols as $key=>$value){
                            $name = $key;
                            $dynamic_column = [
                                'label' => $key,
                                'value'=> function ($model,$key,$index) use ($name,$columnName){
                                    $model = (object)$model;
//                                $datas = $dataProvider->getModels();
//                                var_dump($model);
                                    if (!empty($columnName[$index])){
                                        return $columnName[$index][$name];
                                    }else{
                                        return 'not-set';
                                    }
                                },
                            ];
                            array_push($columns,$dynamic_column);
                    }

                    ?>

                    <?= GridView::widget([
                        'id' => 'applying_list',
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'pjax' => true, // pjax is set to always true for this demo
                        'responsive' => true,
                        'hover' => true,
                        'columns' => $columns,
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
<?php  } ?>
<?php
$this->registerJsFile(
    '@web/js/quality-report.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>