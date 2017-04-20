<?php

use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FinanceCompensationSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Finance Compensations';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div id="nav-menu" data-menu="finance-compensation-index"></div>
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-body">
                    <div class="finance-compensation-index">

                        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                        <?= GridView::widget([
                            'id' => 'compensation-list',
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'pjax' => true,
                            'columns' => [
                                [
                                    'class' => 'kartik\grid\ActionColumn',
                                    'template' => '{all}',
                                    'header' => 'Action',
                                    'buttons' => [
                                        'all' => function ($url, $model, $key) {
                                            if ($model->status == 0) {
                                                return '<div class="dropdown">
                                      <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Actions
                                      <span class="caret"></span></button>
                                      <ul class="dropdown-menu">

                                      <li><a data-delete="0" data-title="' . $this->title . ' ' . $model->deduction_id . '" data-url="/finance-compensation/delete?id=' . $model->deduction_id . '">Delete</a></li>
                                      <li><a data-view="0" data-title="Update Compensation ' . $model->deduction_id . '" data-url="/finance-compensation/update?id=' . $model->deduction_id . '">Update</a></li>
                                      </ul></div>';
                                            }

                                        },
                                    ],
                                ],
                                [
                                    // 'label' => 'id',
                                    'attribute' => 'deduction_id',
                                    'value' => 'deduction_id',
                                ],
                                [
                                    'label' => 'Channel',
                                    'attribute' => 'deduction.channel.username',
//                                    'value' => 'system_cost',
                                ],
                                [
                                    // 'label' => 'system_cost',
                                    'attribute' => 'campaign_id',
                                    'value' => 'deduction.campaign_id',
                                ],
                                [
                                    // 'label' => 'system_revenue',
                                    'attribute' => 'campaign',
                                    'value' => 'deduction.campaign.campaign_name',
                                ],
                                [
                                    // 'label' => 'system_revenue',
                                    'attribute' => 'start_date',
                                    'value' => 'deduction.start_date',
                                    'format' => 'datetime',
                                ],
                                [
                                    // 'label' => 'system_revenue',
                                    'attribute' => 'end_date',
                                    'value' => 'deduction.end_date',
                                ],
                                [
                                    // 'label' => 'system_revenue',
                                    'attribute' => 'deduction_revenue',
                                    'value' => 'deduction.deduction_revenue',
                                ],
                                [
                                    // 'label' => 'system_revenue',
                                    'attribute' => 'deduction_cost',
                                    'value' => 'deduction.deduction_cost',
                                ],
                                [
                                    // 'label' => 'billable_cost',
                                    'attribute' => 'system_cost',
                                    'value' => 'deduction.cost',
                                ],
                                [
                                    // 'label' => 'billable_cost',
                                    'attribute' => 'system_revenue',
                                    'value' => 'deduction.revenue',
                                ],
                                [
                                    // 'label' => 'billable_cost',
                                    'attribute' => 'billable_cost',
                                    'value' => 'billable_cost',
                                ],
                                [
                                    // 'label' => 'billable_cost',
                                    'attribute' => 'billable_cost',
                                    'value' => 'billable_cost',
                                ],
                                [
//                             'label' => 'billable_revenue',
                                    'attribute' => 'billable_revenue',
                                    'value' => 'billable_revenue',
                                ],
                                [
//                             'label' => 'billable_margin',
                                    'attribute' => 'billable_margin',
                                    'value' => 'billable_margin',
                                ],
                                [
//                             'label' => 'compensation',
                                    'attribute' => 'compensation',
                                    'value' => 'compensation',
                                ],
                                [
//                                    'label' => 'final_margin',
                                    'attribute' => 'final_margin',
                                    'value' => 'final_margin',
                                ],
                                [
//                             'label' => 'status',
                                    'attribute' => 'status',
                                    'value' => function ($model) {
                                        return ModelsUtil::getCompensationStatus($model->status);
                                    },
                                    'filter' => ModelsUtil::compensation_status,
                                ],
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
$this->registerJsFile(
    '@web/js/finance-compensation.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

Modal::begin([
    'id' => 'compensation-modal',
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false,
    ],
]);
echo '<div id="compensation-detail-content"></div>';
Modal::end(); ?>