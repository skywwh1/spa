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
if (!empty($dataProvider)) {
    ?>
    <div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
                <div class="channel-quality-report-index">
                    <p>
                        <?php
//                        if ($searchModel->read_only){
                        //                            echo Html::a('<span class="glyphicon glyphicon-plus"></span>', null,
                        //                                [
                        //                                    'title' => Yii::t('yii', 'add Columns'),
                        //                                    'data-url' => 'columns?campaign_id='.$searchModel->campaign_id.'&channel_id='.$searchModel->channel_id,
                        //                                    'data-view' => 0,
                        //                                    'data-pjax' => 0,
                        //                                ]);
                        //                        }
                        echo Html::a('<span class="glyphicon glyphicon-plus"></span>', null,
                            [
                                'title' => Yii::t('yii', 'add Columns'),
                                'data-url' => 'columns?campaign_id='.$searchModel->campaign_id.'&channel_id='.$searchModel->channel_id.'&start='.$searchModel->start.'&end='.$searchModel->end.'&type='.$searchModel->type,
                                'data-view' => 0,
                                'data-pjax' => 0,
                            ]);
                        echo PHP_EOL;
                        echo Html::a('<span class="btn btn-primary">Email</span>', null,
                            [
                                'title' => Yii::t('yii', 'add Columns'),
                                'data-url' => 'email?campaign_id='.$searchModel->campaign_id.'&channel_id='.$searchModel->channel_id.'&start='.$searchModel->start.'&end='.$searchModel->end.'&type='.$searchModel->type,
                                'data-view' => 0,
                                'data-pjax' => 0,
                            ]);
                        echo PHP_EOL;
                        echo Html::a('<span class="btn btn-primary">Notice</span>', null,
                            [
                                'title' => Yii::t('yii', 'Notice'),
                                'data-url' => 'notice?campaign_id='.$searchModel->campaign_id.'&channel_id='.$searchModel->channel_id,
                                'data-view' => 0,
                                'data-pjax' => 0,
                            ]);
                        ?>
                        <button type="button" class="btn btn-primary" id="submit-button">Batch Save</button>
                    </p>
                    <?php
                    $columns = [
                        'timestamp',
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
                             'label' => 'Channel Name',
                            'value' => 'channel_name',
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
//                    $columnName =[
//                        "0"=>
//                            [
//                                "ctt-name" =>"ctt-value0",
//                                "hello-name" => "hello-value0",
//                            ],
//                        "1"=>
//                            [
//                                "ctt-name" =>"ctt-value1",
//                                "hello-name" => "hello-value1",
//                            ],
//                    ];
                    //动态拼接列和行。$clos为手动增加的列数，$colunmnName为手动增加的字段和值组成的数组
//                    var_dump($cols);
//                    var_dump($columnName);
//                    die();
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
//                            'attribute' => 'column_value',
                                'class'=>'kartik\grid\EditableColumn',
                                'editableOptions'=>function ($model,$index)use($name) {
                                    $campaign_id = $model['campaign_id'];
                                    $channel_id = $model['channel_id'];
                                    $sub_channel = $model['sub_channel'];
                                    $time = $model['timestamp'];
                                    return [
                                        'asPopover' => false,
                                        'name'=>$name,
                                        'inputType' => Editable::INPUT_TEXTAREA,
                                        'formOptions' => ['action' => ['/channel-quality-report/update?campaign_id='.$campaign_id.'&channel_id='.$channel_id.'&sub_channel='.$sub_channel.'&time='.$time.'&name='.urlencode($name)]],
                                    ];
                                }
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
<?php \yii\bootstrap\Modal::begin([
    'id' => 'campaign-modal',
    'size' => 'modal-sm',
//    'header' =>'00',
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false,
    ],
]);
echo '<div id="campaign-detail-content"></div>';
\yii\bootstrap\Modal::end(); ?>