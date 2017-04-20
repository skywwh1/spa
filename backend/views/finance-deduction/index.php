<?php

use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FinanceDeductionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Finance Deductions';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div id="nav-menu" data-menu="finance-deduction-index"></div>
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-body">
                    <div class="finance-deduction-index">

                        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                        <p>
                            <?= Html::a('Add Discount', ['add-discount'], ['class' => 'btn btn-success']) ?>
                            <?= Html::a('Add Install Deduction', ['add-install'], ['class' => 'btn btn-success']) ?>
                            <?= Html::a('Add Fine', ['add-fine'], ['class' => 'btn btn-success']) ?>
                        </p>
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                [
                                    'class' => 'kartik\grid\ActionColumn',
                                    'template' => '{all}',
                                    'header' => 'Action',
                                    'buttons' => [
                                        'all' => function ($url, $model, $key) {
//                                        $restart = '';
//                                        if ($model->status != 1) {
//                                            $restart = '<li><a data-pjax="0" data-view="1" data-url="/campaign/restart?id=' . $model->id . '">Restart</a></li>';
//                                        }
                                            return '<div class="dropdown">
                                      <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Actions
                                      <span class="caret"></span></button>
                                      <ul class="dropdown-menu">

                                      <li><a data-view="0" data-title="View deduction ' . $model->id . '" data-url="/finance-deduction/view?id=' . $model->id . '">View</a></li>
                                      <li><a data-view="0" data-title="Confirm deduction ' . $model->id . '" data-url="/finance-deduction/update?id=' . $model->id . '">Confirm</a></li>
                                      <li><a data-view="0" data-title="Apply compensation with deduction ' . $model->id . '" data-url="/finance-compensation/create?deduction_id=' . $model->id . '">Apply Compensation</a></li>'
//                                            $restart
                                                . '</ul>
                                    </div>';
                                        },
                                    ],
                                ],
                                [
                                    // 'label' => 'id',
                                    'attribute' => 'id',
                                    'value' => 'id',
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
                                    // 'label' => 'channel_id',
                                    'attribute' => 'channel_name',
                                    'value' => 'channel.username',
                                ],
                                [
                                    // 'label' => 'start_date',
                                    'attribute' => 'start_date',
                                    'value' => 'start_date',
                                    'format' => 'datetime',
                                ],
                                [
                                    // 'label' => 'end_date',
                                    'attribute' => 'end_date',
                                    'value' => 'end_date',
                                    'format' => 'datetime',
                                ],
                                //[
                                // 'label' => 'installs',
                                // 'attribute' => 'installs',
                                // 'value' => 'installs',
                                // ],
                                //[
                                // 'label' => 'match_installs',
                                // 'attribute' => 'match_installs',
                                // 'value' => 'match_installs',
                                // ],

                                [
//                             'label' => ''
                                    'attribute' => 'deduction_value',
                                    'value' => 'deduction_value',
                                ],
                                [
//                                'label' => 'type',
                                    'attribute' => 'type',
                                    'value' => function ($model) {
                                        return ModelsUtil::getDeductionType($model->type);
                                    },
                                    'filter' => ModelsUtil::deduction_type,
                                ],
                                [
//                             'label' => 'cost',
                                    'attribute' => 'cost',
                                    'value' => 'cost',
                                ],
                                [
//                                'label' => 'deduction_cost',
                                    'attribute' => 'deduction_cost',
                                    'value' => 'deduction_cost',
                                ],
                                [
//                                'label' => 'deduction_revenue',
                                    'attribute' => 'deduction_revenue',
                                    'value' => 'deduction_revenue',
                                ],
                                [
                                    'attribute' => 'revenue',
                                    'value' => 'revenue',
                                ],
                                //[
                                // 'label' => 'margin',
                                // 'attribute' => 'margin',
                                // 'value' => 'margin',
                                // ],
                                //[
                                // 'label' => 'adv',
                                // 'attribute' => 'adv',
                                // 'value' => 'adv',
                                // ],
                                [
                                    'attribute' => 'pm',
                                    'value' => 'pm',
                                ],
                                [
                                    'attribute' => 'bd',
                                    'value' => 'bd',
                                ],
                                [
                                    'attribute' => 'om',
                                    'value' => 'om',
                                ],
                                [
                                    'attribute' => 'status',
                                    'value' => function ($model) {
                                        return ModelsUtil::getDeductionStatus($model->status);
                                    },
                                    'filter' => ModelsUtil::deduction_status,
                                ],
                                //[
                                // 'label' => 'note',
                                // 'attribute' => 'note',
                                // 'value' => 'note:ntext',
                                // ],
                                [
//                                'label' => 'create_time',
                                    'attribute' => 'create_time',
                                    'value' => 'create_time',
                                    'format' => 'datetime',
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
    '@web/js/finance-deduction.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);

Modal::begin([
    'id' => 'deduction-modal',
//    'size' => 'modal-lg',
//    'header'=>'<h4 class="modal-title">Modal title</h4>',
//    'header' =>'00',
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false,
    ],
]);
echo '<div id="deduction-detail-content"></div>';
Modal::end(); ?>