<?php

use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\FinanceAdvertiserBillTerm */
/* @var $receivableList yii\data\ActiveDataProvider */
/* @var $systemRevenueList yii\data\ActiveDataProvider */
/* @var $pendingList yii\data\ActiveDataProvider */
/* @var $deductionList yii\data\ActiveDataProvider */
/* @var $addRevenueList yii\data\ActiveDataProvider */
/* @var $prepaymentList yii\data\ActiveDataProvider */


$this->title = 'Update Finance Advertiser Bill Term: ' . $model->bill_id;
$this->params['breadcrumbs'][] = ['label' => 'Finance Advertiser Bill Terms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->bill_id, 'url' => ['view', 'id' => $model->bill_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Basic Info</h3>
                </div>

                <?php $form = ActiveForm::begin([
                    'options' => ['class' => 'form-horizontal'],
                    'id' => 'finance-channel-bill-term-form',
                ]); ?>
                <div class="box-body">

                    <?= $form->field($model, 'bill_id', [
                        'labelOptions' => ['class' => 'col-sm-2 control-label'],
                        'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                    ])->textInput(['maxlength' => true, 'readonly' => 'readonly']) ?>
                    <?= $form->field($model, 'invoice_id', [
                        'labelOptions' => ['class' => 'col-sm-2 control-label'],
                        'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                    ])->textInput(['maxlength' => true, 'readonly' => 'readonly']) ?>
                    <?= $form->field($model, 'period', [
                        'labelOptions' => ['class' => 'col-sm-2 control-label'],
                        'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                    ])->textInput(['maxlength' => true, 'readonly' => 'readonly']) ?>
                    <?= $form->field($model, 'adv_id', [
                        'labelOptions' => ['class' => 'col-sm-2 control-label'],
                        'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                    ])->textInput(['readonly' => 'readonly']) ?>
                    <?= $form->field($model, 'time_zone', [
                        'labelOptions' => ['class' => 'col-sm-2 control-label'],
                        'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                    ])->dropDownList(ModelsUtil::timezone, ['disabled ' => 'disabled ']) ?>
                    <?= $form->field($model, 'status', [
                        'labelOptions' => ['class' => 'col-sm-2 control-label'],
                        'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                    ])->textInput(['readonly' => 'readonly']) ?>
                    <?= $form->field($model, 'update_time', [
                        'labelOptions' => ['class' => 'col-sm-2 control-label'],
                        'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                    ])->textInput(['readonly' => 'readonly']) ?>
                    <?= $form->field($model, 'note', [
                        'labelOptions' => ['class' => 'col-sm-2 control-label'],
                        'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                    ])->textarea(['rows' => 6]) ?>

                </div>

                <div class="box-footer">
                    <div class="col-lg-2">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                    </div>
                    <div class="col-lg-2">
                        <?= Html::button('Export Excel', ['class' => 'btn btn-primary']) ?>
                    </div>
                    <div class="col-lg-2">
                        <?= Html::button('Upload File', ['class' => 'btn btn-primary']) ?>
                    </div>
                    <div class="col-lg-2">
                        <?= Html::button('Download File', ['class' => 'btn btn-primary']) ?>
                    </div>
                    <div class="col-lg-2">
                        <?= Html::a('Add Revenue', null, [
                            'class' => 'btn btn-primary',
                            'data-title' => 'Add Revenue',
                            'data-url' => '/finance-add-revenue/create?bill_id=' . $model->bill_id,
                            'data-view' => 0,
                        ]) ?>
                    </div>
                    <div class="col-lg-2">
                        <?= Html::a('Apply Prepayment', null, [
                            'class' => 'btn btn-primary',
                            'data-title' => 'Apply prepayment',
                            'data-url' => '/finance-advertiser-prepayment/create?bill_id=' . $model->bill_id,
                            'data-view' => 0,
                        ]) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>
    <!-- Payable -->
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-body">
                    <p>
                    <h4>Payable</h4>
                    </p>
                    <?= GridView::widget([
                        'dataProvider' => $receivableList,
                        'layout' => '{items}',
                        'columns' => [
                            [
                                // 'label' => 'invoice_id',
                                'attribute' => 'status',
                                'value' => function ($model) {
                                    return ModelsUtil::getReceivableStatus($model->status);
                                },
                                'filter' => ModelsUtil::receivable_status,
                            ],
                            [
                                // 'label' => 'invoice_id',
                                'attribute' => 'invoice_id',
                                'value' => 'invoice_id',
                            ],
                            [
                                // 'label' => 'adv_id',
                                'attribute' => 'adv_id',
                                'value' => 'adv.username',
                            ],
                            [
                                // 'label' => 'time_zone',
                                'attribute' => 'time_zone',
                                'value' => function ($model) {
                                    return ModelsUtil::getTimezone($model->time_zone);
                                },
                                'filter' => ModelsUtil::timezone,

                            ],
//                            [
//                                // 'label' => 'start_time',
//                                'attribute' => 'start_time',
//                                'value' => 'start_time',
//                                'format' => 'datetime',
//                            ],
//                            [
//                                // 'label' => 'end_time',
//                                'attribute' => 'end_time',
//                                'value' => 'end_time',
//                                'format' => 'datetime',
//                            ],
//                            [
//                                'label' => 'clicks',
//                                'attribute' => 'clicks',
//                                'value' => 'clicks',
//                            ],
//                            [
//                                'label' => 'unique_clicks',
//                                'attribute' => 'unique_clicks',
//                                'value' => 'unique_clicks',
//                            ],
//                            [
//                                'label' => 'installs',
//                                'attribute' => 'installs',
//                                'value' => 'installs',
//                            ],
//                            [
//                                'label' => 'match_installs',
//                                'attribute' => 'match_installs',
//                                'value' => 'match_installs',
//                            ],
//                            [
//                                'label' => 'redirect_installs',
//                                'attribute' => 'redirect_installs',
//                                'value' => 'redirect_installs',
//                            ],
//                            [
//                                'label' => 'redirect_match_installs',
//                                'attribute' => 'redirect_match_installs',
//                                'value' => 'redirect_match_installs',
//                            ],
//                            [
//                                'label' => 'pay_out',
//                                'attribute' => 'pay_out',
//                                'value' => 'pay_out',
//                            ],
//                            [
//                                'label' => 'adv_price',
//                                'attribute' => 'adv_price',
//                                'value' => 'adv_price',
//                            ],
//                            [
//                                'label' => 'cost',
//                                'attribute' => 'cost',
//                                'value' => 'cost',
//                            ],
//                            [
//                                'label' => 'redirect_cost',
//                                'attribute' => 'redirect_cost',
//                                'value' => 'redirect_cost',
//                            ],
                            [
                                'attribute' => 'revenue',
                                'value' => 'revenue',
                            ],
                            [
                                'attribute' => 'receivable',
                                'value' => 'receivable',
                            ],
                            [
                                'attribute' => 'period',
                                'value' => 'adv.bd0.username',
                            ],
                            [
                                'attribute' => 'period',
                                'value' => 'period',
                            ],
//                            [
//                                'label' => 'redirect_revenue',
//                                'attribute' => 'redirect_revenue',
//                                'value' => 'redirect_revenue',
//                            ],

                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- system revenue -->
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-body">
                    <p>
                    <h4>System Revenue</h4>
                    </p>
                    <?= GridView::widget([
                        'dataProvider' => $systemRevenueList,
                        'layout' => '{items}',
                        'columns' => [

                            [
                                // 'label' => 'bill_id',
                                'attribute' => 'bill.period',
                            ],
                            [
                                // 'label' => 'campaign_id',
                                'attribute' => 'campaign_id',
                                'value' => 'campaign_id',
                            ],
                            [
                                // 'label' => 'time_zone',
                                'attribute' => 'campaign.campaign_name',
//                                'value' => 'time_zone',
                            ],
                            [
//                             'label' => 'clicks',
                                'attribute' => 'clicks',
                                'value' => 'clicks',
                            ],
                            //[
                            // 'label' => 'unique_clicks',
                            // 'attribute' => 'unique_clicks',
                            // 'value' => 'unique_clicks',
                            // ],
                            //[
                            // 'label' => 'installs',
                            // 'attribute' => 'installs',
                            // 'value' => 'installs',
                            // ],
                            [
//                             'label' => 'match_installs',
                                'attribute' => 'match_installs',
                                'value' => 'match_installs',
                            ],
                            //[
                            // 'label' => 'redirect_installs',
                            // 'attribute' => 'redirect_installs',
                            // 'value' => 'redirect_installs',
                            // ],
                            //[
                            // 'label' => 'redirect_match_installs',
                            // 'attribute' => 'redirect_match_installs',
                            // 'value' => 'redirect_match_installs',
                            // ],
                            [
//                             'label' => 'pay_out',
                                'attribute' => 'pay_out',
                                'value' => 'pay_out',
                            ],
                            //[
                            // 'label' => 'adv_price',
                            // 'attribute' => 'adv_price',
                            // 'value' => 'adv_price',
                            // ],
                            //[
                            // 'label' => 'daily_cap',
                            // 'attribute' => 'daily_cap',
                            // 'value' => 'daily_cap',
                            // ],
                            //[
                            // 'label' => 'cap',
                            // 'attribute' => 'cap',
                            // 'value' => 'cap',
                            // ],
                            [
//                             'label' => 'cost',
                                'attribute' => 'cost',
                                'value' => 'cost',
                            ],
                            //[
                            // 'label' => 'redirect_cost',
                            // 'attribute' => 'redirect_cost',
                            // 'value' => 'redirect_cost',
                            // ],
                            [
//                             'label' => 'revenue',
                                'attribute' => 'revenue',
                                'value' => 'revenue',
                            ],
                            [
                                'label' => 'Margin',
                                'attribute' => 'redirect_revenue',
                                'value' => function ($model) {
                                    return $model->revenue == 0 ? 0 : round((($model->revenue - $model->cost) / $model->revenue), 2);
                                }
                            ],
                            [
                                'label' => 'ADV',
                                'value' => 'bill.adv.username',
                            ],
                            [
                                'label' => 'BD',
                                'value' => 'bill.adv.bd0.username',
                            ],

                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Pending -->
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-body">
                    <p>
                    <h4>Pending</h4>
                    </p>
                    <?= GridView::widget([
                        'dataProvider' => $pendingList,
                        'columns' => [
                            [
                                // 'label' => 'bill_id',
                                'attribute' => 'channel_bill_id',
                                'value' => 'channel_bill_id',
                            ],
                            [
                                // 'label' => 'channel_id',
                                'attribute' => 'channel_id',
                                'value' => 'channel_id',
                            ],
//                        [
//                            // 'label' => 'time_zone',
//                            'attribute' => 'time_zone',
//                            'value' => 'time_zone',
//                        ],
                            [
                                // 'label' => 'campaign_id',
                                'attribute' => 'campaign_id',
                                'value' => 'campaign_id',
                            ],
//                    [
//                        // 'label' => 'start_time',
//                        'attribute' => 'start_time',
//                        'value' => 'start_time:datetime',
//                    ],
                            //[
                            // 'label' => 'end_time',
                            // 'attribute' => 'end_time',
                            // 'value' => 'end_time:datetime',
                            // ],
                            //[
                            // 'label' => 'clicks',
                            // 'attribute' => 'clicks',
                            // 'value' => 'clicks',
                            // ],
                            //[
                            // 'label' => 'unique_clicks',
                            // 'attribute' => 'unique_clicks',
                            // 'value' => 'unique_clicks',
                            // ],
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
                            //[
                            // 'label' => 'redirect_installs',
                            // 'attribute' => 'redirect_installs',
                            // 'value' => 'redirect_installs',
                            // ],
                            //[
                            // 'label' => 'redirect_match_installs',
                            // 'attribute' => 'redirect_match_installs',
                            // 'value' => 'redirect_match_installs',
                            // ],
                            //[
                            // 'label' => 'pay_out',
                            // 'attribute' => 'pay_out',
                            // 'value' => 'pay_out',
                            // ],
                            //[
                            // 'label' => 'adv_price',
                            // 'attribute' => 'adv_price',
                            // 'value' => 'adv_price',
                            // ],
                            //[
                            // 'label' => 'daily_cap',
                            // 'attribute' => 'daily_cap',
                            // 'value' => 'daily_cap',
                            // ],
                            //[
                            // 'label' => 'cap',
                            // 'attribute' => 'cap',
                            // 'value' => 'cap',
                            // ],
                            //[
                            // 'label' => 'cost',
                            // 'attribute' => 'cost',
                            // 'value' => 'cost',
                            // ],
                            //[
                            // 'label' => 'redirect_cost',
                            // 'attribute' => 'redirect_cost',
                            // 'value' => 'redirect_cost',
                            // ],
                            //[
                            // 'label' => 'revenue',
                            // 'attribute' => 'revenue',
                            // 'value' => 'revenue',
                            // ],
                            //[
                            // 'label' => 'redirect_revenue',
                            // 'attribute' => 'redirect_revenue',
                            // 'value' => 'redirect_revenue',
                            // ],
                            //[
                            // 'label' => 'note',
                            // 'attribute' => 'note',
                            // 'value' => 'note:ntext',
                            // ],
                            //[
                            // 'label' => 'create_time',
                            // 'attribute' => 'create_time',
                            // 'value' => 'create_time:datetime',
                            // ],
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
    <!-- Deduction -->
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-body">
                    <p>
                    <h4>Deduction</h4>
                    </p>
                    <?= GridView::widget([
                        'dataProvider' => $deductionList,
                        'columns' => [
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
    <!-- Add revenue -->
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-body">
                    <p>
                    <h4>Add revenue</h4>
                    </p>
                    <?= GridView::widget([
                        'dataProvider' => $addRevenueList,
                        'showPageSummary' => true,
                        'columns' => [
                            [
                                // 'label' => 'revenue',
                                'attribute' => 'revenue',
                                'value' => 'revenue',
                                'pageSummary' => true,
                            ],
                            //[
                            // 'label' => 'om',
                            // 'attribute' => 'om',
                            // 'value' => 'om',
                            // ],
                            [
                                'attribute' => 'note',
                            ],
                            //[
                            // 'label' => 'create_time',
                            // 'attribute' => 'create_time',
                            // 'value' => 'create_time:datetime',
                            // ],
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
    <!-- apply prepayment -->
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h4>Apply Prepayment</h4>

                </div>
                <div class="box-body">
                    <?= GridView::widget([
                        'dataProvider' => $prepaymentList,
                        'showPageSummary' => true,
                        'columns' => [
                            [
                                // 'label' => 'prepayment',
                                'attribute' => 'prepayment',
                                'value' => 'prepayment',
                                'pageSummary' => true,
                            ],
                            //[
                            // 'label' => 'om',
                            // 'attribute' => 'om',
                            // 'value' => 'om',
                            // ],
                            [
                                'label' => 'note',
                                'attribute' => 'note',
                                'value' => 'note',
                                'format' => 'ntext',
                            ],
                            //[
                            // 'label' => 'create_time',
                            // 'attribute' => 'create_time',
                            // 'value' => 'create_time:datetime',
                            // ],
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