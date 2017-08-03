<?php

use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use kartik\date\DatePicker;
use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\FinancePendingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $summary yii\data\ActiveDataProvider */
/* @var $system array() */
$this->title = 'Finance Pendings';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div id="nav-menu" data-menu="finance-pending-index"></div>
<?php  echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-body">
                    <div class="finance-pending-index">
                        <p>
                            <?= Html::a('Add Campaign Pending', ['add-campaign'], ['class' => 'btn btn-primary']) ?>
                            <?= Html::a('Add ADV Pending', ['add-adv'], ['class' => 'btn btn-primary']) ?>
                        </p>
                        <?php
                        $summary_columns = [
                            'pending_cost',
                            'pending_revenue',
                            'confirm_cost',
                            'confirm_revenue',
                            [
                                'label' => 'margin',
                                'value' => function($model){
                                    $model = (Object)$model;
                                    return $model->confirm_revenue == 0 ? 0.00 : round((($model->confirm_revenue - $model->confirm_cost) / $model->confirm_revenue)*100, 2).'%';
                                }
                            ],
                        ];

//                        if(!empty($system['cost']) || empty($system['revenue'])){
////                            var_dump($system['cost'],$system['revenue']);
////                            die();
//                            $system_column = [
//                                [
//                                    'label' => 'system_cost',
//                                    'value'=> function ($model) use ($system){
//                                        if (!empty($model)){
//                                            if (!empty($system['cost'])){
//                                                return $system['cost'];
//                                            }else{
//                                                return '0';
//                                            }
//                                        }
//                                        return '0';
//                                    },
//                                ],
//                                [
//                                    'label' => 'system_revenue',
//                                    'value'=> function ($model) use ($system){
//                                        if (!empty($model)){
//                                            if (!empty($system['revenue'])){
//                                                return $system['revenue'];
//                                            }else{
//                                                return '0';
//                                            }
//                                        }
//                                        return '0';
//                                    },
//                                ]
//                            ];
//                            array_push($summary_columns,$system_column);
//                        }
                       echo GridView::widget([
                            'dataProvider' => $summary,
                            'columns' => $summary_columns,
                        ]);

                        $columns = [
                            [
                                // 'label' => 'id',
                                'attribute' => 'id',
                                'value' => 'id',
                            ],
                            [
                                'label' => 'Channel',
                                'attribute' => 'channel_name',
                                'value' => 'channel.username',
                            ],
                            [
                                'label' => 'adv',
                                'attribute' => 'adv',
                                'value' => 'adv',
                            ],
                            [
                                'attribute' => 'month',
                                'value' => function($model){
                                    return isset($model->adv_bill_id) ? substr($model->adv_bill_id,3) : Yii::$app->formatter->asDate('now', 'php:Y-m');
                                },
                                'filter' =>  DatePicker::widget([
                                    'model' => $searchModel,
                                    'attribute' => 'month',
                                    'name' => 'month',
                                    'type' => DatePicker::TYPE_INPUT,
                                    'pluginOptions' => [
                                        'autoclose'=>true,
                                        'format' => 'yyyymm',
                                    ],
                                ]),
                            ],
                            [
                                // 'label' => 'campaign_id',
                                'attribute' => 'campaign_id',
                                'value' => 'campaign_id',
                            ],
                            [
                                'label' => 'Campaign',
                                'attribute' => 'campaign_name',
                                'value' => 'campaign.name',
                            ],
                            [
                                // 'label' => 'start_date',
                                'attribute' => 'start_date',
                                'value' => function ($model) {
                                    $format = 'Y-m-d';
                                    $date = new DateTime();
                                    $date->setTimezone(new DateTimeZone('Etc/GMT-8'));
                                    $date->setTimestamp($model->start_date);
                                    return $date->format($format);
                                },
                                'filter' => false,
                            ],
                            [
                                // 'label' => 'end_date',
                                'attribute' => 'end_date',
                                'value' => function ($model) {
                                    $format = 'Y-m-d';
                                    $date = new DateTime();
                                    $date->setTimezone(new DateTimeZone('Etc/GMT-8'));
                                    $date->setTimestamp($model->end_date);
                                    return $date->format($format);
                                },
                                'filter' => false,
                            ],

                            [
                                'label' => 'installs',
                                'attribute' => 'installs',
                                'value' => 'installs',
                            ],
                            [
                                'label' => 'cost',
                                'attribute' => 'cost',
                                'value' => 'cost',
                            ],
                            [
                                'label' => 'revenue',
                                'attribute' => 'revenue',
                                'value' => 'revenue',
                            ],
                            [
                                'label' => 'margin',
                                'attribute' => 'margin',
                                'value' => 'margin',
                            ],

                            [
                                'label' => 'pm',
                                'attribute' => 'pm',
                                'value' => 'pm',
                            ],
                            [
                                'label' => 'bd',
                                'attribute' => 'bd',
                                'value' => 'bd',
                            ],
                            [
                                'label' => 'om',
                                'attribute' => 'om',
                                'value' => 'om',
                            ],
                            [
                                'label' => 'status',
                                'attribute' => 'status',
                                'value' => function ($model) {
                                    return ModelsUtil::getPendingStatus($model->status);
                                },
                                'filter' => ModelsUtil::pending_status,
                            ],
                            [
                                'label' => 'create_time',
                                'attribute' => 'create_time',
                                'value' => 'create_time',
                            ],
                        ];
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
                            'id' => 'pending-list',
                            'showPageSummary' => true,
                            'pjax' => false,
                            'columns' => [
                                [
                                    'class' => 'kartik\grid\ActionColumn',
                                    'template' => '{all}',
                                    'header' => 'Action',
                                    'buttons' => [
                                        'all' => function ($url, $model, $key) {
                                            return '<div class="dropdown">
                                      <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Actions
                                      <span class="caret"></span></button>
                                      <ul class="dropdown-menu">

                                      <li><a data-view="0" data-title="View Pending ' . $model->id . '" data-url="/finance-pending/view?id=' . $model->id . '">View</a></li>
                                      </ul>
                                    </div>';
                                        },
                                    ],
                                ],
                                [
                                    'label' => 'status',
                                    'attribute' => 'status',
                                    'value' => function ($model) {
                                        return ModelsUtil::getPendingStatus($model->status);
                                    },
                                    'filter' => ModelsUtil::pending_status,
                                    'contentOptions' => function ($model) {
//                                        $model = (object)$model;
                                        if ($model->status > 0) {
                                            return ['class' => 'bg-green'];
                                        }else{
                                            return ['class' => 'bg-danger'];
                                        }
                                    }
                                ],
                                [
                                    // 'label' => 'id',
                                    'attribute' => 'id',
                                    'value' => 'id',
                                ],
                                [
                                    'label' => 'Channel',
                                    'attribute' => 'channel_name',
                                    'value' => 'channel.username',
                                ],
                                [
                                    'label' => 'adv',
                                    'attribute' => 'adv',
                                    'value' => 'adv',
                                ],
                                [
                                   'attribute' => 'month',
                                    'value' => function($model){
                                        return isset($model->adv_bill_id) ? substr($model->adv_bill_id,3) : Yii::$app->formatter->asDate('now', 'php:Y-m');
                                    },
                                    'filter' =>  DatePicker::widget([
                                        'model' => $searchModel,
                                        'attribute' => 'month',
                                        'name' => 'month',
                                        'type' => DatePicker::TYPE_INPUT,
                                        'pluginOptions' => [
                                            'autoclose'=>true,
                                            'format' => 'yyyymm',
                                        ],
                                    ]),
                                ],
                                [
                                    // 'label' => 'campaign_id',
                                    'attribute' => 'campaign_id',
                                    'value' => 'campaign_id',
                                ],
                                [
                                    'label' => 'Campaign',
                                    'attribute' => 'campaign_name',
                                    'value' => 'campaign.name',
                                ],
                                [
                                    // 'label' => 'start_date',
                                    'attribute' => 'start_date',
                                    'value' => function ($model) {
                                        $format = 'Y-m-d';
                                        $date = new DateTime();
                                        $date->setTimezone(new DateTimeZone('Etc/GMT-8'));
                                        $date->setTimestamp($model->start_date);
                                        return $date->format($format);
                                    },
                                    'filter' => false,
                                ],
                                [
                                    // 'label' => 'end_date',
                                    'attribute' => 'end_date',
                                    'value' => function ($model) {
                                        $format = 'Y-m-d';
                                        $date = new DateTime();
                                        $date->setTimezone(new DateTimeZone('Etc/GMT-8'));
                                        $date->setTimestamp($model->end_date);
                                        return $date->format($format);
                                    },
                                    'filter' => false,
                                ],

                                [
                                    'label' => 'installs',
                                    'attribute' => 'installs',
                                    'value' => 'installs',
                                ],
                                [
                                    'label' => 'cost',
                                    'attribute' => 'cost',
                                    'value' => 'cost',
                                    'pageSummary' => true,
                                ],
                                [
                                    'label' => 'revenue',
                                    'attribute' => 'revenue',
                                    'value' => 'revenue',
                                    'pageSummary' => true,
                                ],
                                [
                                    'label' => 'margin',
                                    'attribute' => 'margin',
                                    'value' => 'margin',
                                ],
                                [
                                    'label' => 'pm',
                                    'attribute' => 'pm',
                                    'value' => 'pm',
                                ],
                                [
                                    'label' => 'bd',
                                    'attribute' => 'bd',
                                    'value' => 'bd',
                                ],
                                [
                                    'label' => 'om',
                                    'attribute' => 'om',
                                    'value' => 'om',
                                ],
                                //[
                                // 'label' => 'note',
                                // 'attribute' => 'note',
                                // 'value' => 'note:ntext',
                                // ],
                                [
                                    'attribute' => 'create_time',
                                    'value' => function ($model) {
                                        return gmdate('Y-m-d H:i',$model->create_time + 8*3600);
                                    },
                                    'filter' => false,
                                ],
                                //[
                                // 'label' => 'update_time',
                                // 'attribute' => 'update_time',
                                // 'value' => 'update_time:datetime',
                                // ],

                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
$this->registerJsFile(
    '@web/js/finance-pending-campaign.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

Modal::begin([
    'id' => 'pending-modal',
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false,
    ],
]);
echo '<div id="pending-detail-content"></div>';
Modal::end(); ?>