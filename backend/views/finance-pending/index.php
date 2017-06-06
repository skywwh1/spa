<?php

use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use kartik\date\DatePicker;
use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\FinancePendingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Finance Pendings';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div id="nav-menu" data-menu="finance-pending-index"></div>
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-body">
                    <div class="finance-pending-index">

<!--                        --><?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                        <p>
                            <?= Html::a('Add Campaign Pending', ['add-campaign'], ['class' => 'btn btn-success']) ?>
                            <?= Html::a('Add ADV Pending', ['add-adv'], ['class' => 'btn btn-success']) ?>
                        </p>
                        <?php
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
                                'label' => 'adv',
                                'attribute' => 'adv',
                                'value' => 'adv',
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
                                    'label' => 'adv',
                                    'attribute' => 'adv',
                                    'value' => 'adv',
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
                                    'label' => 'create_time',
                                    'attribute' => 'create_time',
                                     'value' => 'create_time',
                                    'format' => 'datetime',
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