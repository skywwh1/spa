<?php

use kartik\file\FileInput;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\FinanceChannelBillTerm */
/* @var $searchModel backend\models\FinanceChannelCampaignBillTermSearch */
/* @var $campaignBill yii\data\ActiveDataProvider */
/* @var $pendingList yii\data\ActiveDataProvider */
/* @var $prepaymentList yii\data\ActiveDataProvider */
/* @var $costList yii\data\ActiveDataProvider */
/* @var $payable yii\data\ActiveDataProvider */
/* @var $deductionList yii\data\ActiveDataProvider */
/* @var $compensationList yii\data\ActiveDataProvider */
/* @var $upload backend\models\UploadForm; */


$this->title = 'Update Finance Channel Bill Term: ' . $model->bill_id;
$this->params['breadcrumbs'][] = ['label' => 'Finance Channel Bill', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->bill_id, 'url' => ['view', 'id' => $model->bill_id]];
?>

    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title">Basic Info</h3>
                </div>

                <?php $form = ActiveForm::begin([
                    'options' => ['class' => 'form-horizontal','enctype' => 'multipart/form-data'],
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
                    <?= $form->field($model, 'channel_id', [
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
                    <?php ActiveForm::end(); ?>
                    <div class="col-lg-2">
                        <?= Html::button('Export Excel', ['class' => 'btn btn-primary']) ?>
                    </div>
                    <div class="col-lg-2">
                        <?php
                        Modal::begin([
                            'header'=>'File Upload',
                            'toggleButton' => [
                                'label'=>'Upload File', 'class'=>'btn btn-primary'
                            ],
                        ]);
                        echo FileInput::widget([
                            'name' => 'imageFiles[]',
                            'language' => 'en',
                            'options' => ['multiple' => true],
                            'pluginOptions' => ['previewFileType' => 'any', 'uploadUrl' => Url::to(['/finance-channel-bill-term/upload'])]
                        ]);
                        Modal::end();

                        //Html::a('Upload File', ['upload'],['class' => 'btn btn-primary']) ?>
                    </div>
                    <div class="col-lg-2">
                        <?= Html::submitButton('Download File', ['class' => 'btn btn-primary']) ?>
                    </div>
                    <div class="col-lg-2">
                        <?= Html::a('Add Cost', null, [
                            'class' => 'btn btn-primary',
                            'data-title' => 'Add Cost',
                            'data-url' => '/finance-add-cost/create?bill_id=' . $model->bill_id,
                            'data-view' => 0,
                        ]) ?>
                    </div>
                    <div class="col-lg-2">
                        <?= Html::a('Apply Prepayment', null, [
                            'class' => 'btn btn-primary',
                            'data-title' => 'Apply prepayment',
                            'data-url' => '/finance-channel-prepayment/create?bill_id=' . $model->bill_id,
                            'data-view' => 0,
                        ]) ?>
                    </div>
                </div>


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
                        'dataProvider' => $payable,
                        'layout' => '{items}',
                        'columns' => [
                            [
                                'label' => 'Account Type',
//                                    'attribute' => 'bill_id',
                                'value' => function ($model) {
                                    return ModelsUtil::getPaymentTerm($model->channel->payment_term);
                                }
                            ],
//                            [
//                                // 'label' => 'bill_id',
//                                'attribute' => 'bill_id',
//                                'value' => 'bill_id',
//                            ],
                            [
                                'label' => 'System Cost',
                                'attribute' => 'cost',
                                'value' => 'cost',
                            ],
                            [
//                                'label' => 'add_historic_cost',
                                'attribute' => 'add_historic_cost',
                                'value' => 'add_historic_cost',
                            ],
                            [
//                                'label' => 'pending',
                                'attribute' => 'pending',
                                'value' => 'pending',
                            ],
                            [
//                                'label' => 'deduction',
                                'attribute' => 'deduction',
                                'value' => 'deduction',
                            ],
                            [
//                                'label' => 'compensation',
                                'attribute' => 'compensation',
                                'value' => 'compensation',
                            ],
                            [
//                                'label' => 'add_cost',
                                'attribute' => 'add_cost',
                                'value' => 'add_cost',
                            ],
                            [
//                                'label' => 'final_cost',
                                'attribute' => 'final_cost',
                                'value' => 'final_cost',
                            ],
                            [
//                                'label' => 'actual_margin',
                                'attribute' => 'actual_margin',
                                'value' => 'actual_margin',
                            ],
                            [
//                                'label' => 'paid_amount',
                                'attribute' => 'paid_amount',
                                'value' => 'paid_amount',
                            ],
                            [
//                                'label' => 'payable',
                                'attribute' => 'payable',
                                'value' => 'payable',
                            ],
                            [
//                                'label' => 'apply_prepayment',
                                'attribute' => 'apply_prepayment',
                                'value' => 'apply_prepayment',
                            ],
                            [
//                                'label' => 'balance',
                                'attribute' => 'balance',
                                'value' => 'balance',
                            ],
//                            [
//                                // 'label' => 'invoice_id',
//                                'attribute' => 'invoice_id',
//                                'value' => 'invoice_id',
//                            ],
//                            [
//                                // 'label' => 'period',
//                                'attribute' => 'period',
//                                'value' => 'period',
//                            ],
//                            [
//                                // 'label' => 'channel_id',
//                                'attribute' => 'channel_id',
//                                'value' => 'channel_id',
//                            ],
//                            [
//                                // 'label' => 'time_zone',
//                                'attribute' => 'time_zone',
//                                'value' => 'time_zone',
//                            ],
                            //[
                            // 'label' => 'start_time',
                            // 'attribute' => 'start_time',
                            // 'value' => 'start_time:datetime',
                            // ],
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
                            // 'label' => 'status',
                            // 'attribute' => 'status',
                            // 'value' => 'status',
                            // ],
                            //[
                            // 'label' => 'note',
                            // 'attribute' => 'note',
                            // 'value' => 'note:ntext',
                            // ],
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

                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- history cost -->
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-body">
                    <p>
                    <h4>Add Historic Cost</h4>
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
    <!-- system cost -->
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-body">
                    <p>
                    <h4>System Cost</h4>
                    </p>
                    <?= GridView::widget([
                        'dataProvider' => $campaignBill,
                        'pjax' => true,
                        'showPageSummary' => true,
                        'columns' => [
                            [
                                // 'label' => 'start_time',
                                'attribute' => 'bill.period',
                                'pageSummary' => 'Summary',
                            ],
                            [
                                // 'label' => 'channel_id',
                                'attribute' => 'channel_id',
                                'value' => 'channel_id',
                            ],
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
                            [
//                                'label' => 'clicks',
                                'attribute' => 'clicks',
                                'value' => 'clicks',
                                'pageSummary' => true,
                            ],
                            //[
                            // 'label' => 'unique_clicks',
                            // 'attribute' => 'unique_clicks',
                            // 'value' => 'unique_clicks',
                            // ],
                            [
//                                'label' => 'installs',
                                'attribute' => 'installs',
                                'value' => 'installs',
                                'pageSummary' => true,
                            ],
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
                                'label' => 'cost',
                                'attribute' => 'cost',
                                'value' => 'cost',
                                'pageSummary' => true,
                            ],
                            //[
                            // 'label' => 'redirect_cost',
                            // 'attribute' => 'redirect_cost',
                            // 'value' => 'redirect_cost',
                            // ],
                            [
//                                'label' => 'revenue',
                                'attribute' => 'revenue',
                                'value' => 'revenue',
                                'pageSummary' => true,
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
                                'value' => function ($model) {
                                    return $model->campaign->advertiser0->username;
                                }
                            ],
                            [
                                'label' => 'BD',
                                'value' => function ($model) {
                                    return $model->campaign->advertiser0->bd0->username;
                                }
                            ],
                            [
                                'label' => 'PM',
                                'value' => function ($model) {
                                    return null;
                                }
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
    <!-- deduction -->
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
    <!-- compensation -->
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-body">
                    <p>
                    <h4>Compensation</h4>
                    </p>
                    <?= GridView::widget([
                        'dataProvider' => $compensationList,
                        'pjax' => true,
                        'columns' => [
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
    <!-- add cost-->
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-body">
                    <p>
                    <h4>Add Cost</h4>
                    </p>
                    <?= GridView::widget([
                        'dataProvider' => $costList,
                        'columns' => [

                            [
                                // 'label' => 'cost',
                                'attribute' => 'cost',
                                'value' => 'cost',
                            ],
                            //[
                            // 'label' => 'om',
                            // 'attribute' => 'om',
                            // 'value' => 'om',
                            // ],
                            [
                                'attribute' => 'note',
                                'value' => 'note',
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
                        'columns' => [
                            [
                                // 'label' => 'prepayment',
                                'attribute' => 'prepayment',
                                'value' => 'prepayment',
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
Modal::end();
?>