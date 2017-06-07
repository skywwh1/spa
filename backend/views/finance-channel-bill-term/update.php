<?php

use kartik\file\FileInput;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
use kartik\editable\Editable;

/* @var $this yii\web\View */
/* @var $model backend\models\FinanceChannelBillTerm */
/* @var $searchModel backend\models\FinanceChannelBillTermSearch */
/* @var $campaignBill yii\data\ActiveDataProvider */
/* @var $pendingList yii\data\ActiveDataProvider */
/* @var $prepaymentList yii\data\ActiveDataProvider */
/* @var $costList yii\data\ActiveDataProvider */
/* @var $payable yii\data\ActiveDataProvider */
/* @var $deductionList yii\data\ActiveDataProvider */
/* @var $compensationList yii\data\ActiveDataProvider */
/* @var $upload backend\models\UploadForm; */
/* @var $channel common\models\Channel; */


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
                    <?php
                        if(\Yii::$app->user->can('admin')){
                            echo $form->field($model, 'status', [
                            'labelOptions' => ['class' => 'col-sm-2 control-label'],
                            'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                            ])->dropDownList(ModelsUtil::payable_status);
                        }else{
                            echo $form->field($model, 'status', [
                                'labelOptions' => ['class' => 'col-sm-2 control-label'],
                                'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                            ])->dropDownList(ModelsUtil::payable_status_om);
                        }
                    ?>
                    <?= $form->field($model, 'update_time', [
                        'labelOptions' => ['class' => 'col-sm-2 control-label'],
                        'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                    ])->textInput(['readonly' => 'readonly']) ?>
                    <?= $form->field($channel, 'beneficiary_name', [
                        'labelOptions' => ['class' => 'col-sm-2 control-label'],
                        'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                    ])->textInput(['readonly' => 'readonly']) ?>
                    <?= $form->field($channel, 'account_nu_iban', [
                        'labelOptions' => ['class' => 'col-sm-2 control-label'],
                        'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                    ])->textInput(['readonly' => 'readonly']) ?>
                    <?= $form->field($channel, 'bank_name', [
                        'labelOptions' => ['class' => 'col-sm-2 control-label'],
                        'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                    ])->textInput(['readonly' => 'readonly']) ?>
                    <?= $form->field($channel, 'bank_address', [
                        'labelOptions' => ['class' => 'col-sm-2 control-label'],
                        'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                    ])->textInput(['readonly' => 'readonly']) ?>
                    <?= $form->field($channel, 'swift', [
                        'labelOptions' => ['class' => 'col-sm-2 control-label'],
                        'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                    ])->textInput(['readonly' => 'readonly']) ?>
                    <?= $form->field($model, 'note', [
                        'labelOptions' => ['class' => 'col-sm-2 control-label'],
                        'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                    ])->textarea(['rows' => 6]) ?>
                </div>

                <div class="box-footer">
                    <div class="col-lg-1">
                        <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                    </div>
                    <?php ActiveForm::end(); ?>
                    <div class="col-lg-1">
                        <?= Html::button('Export', ['class' => 'btn btn-primary']) ?>
                    </div>
                    <div class="col-lg-1">
                        <?php
                        Modal::begin([
                            'header'=>'File Upload',
                            'toggleButton' => [
                                'label'=>'Upload', 'class'=>'btn btn-primary'
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
                        <?= Html::submitButton('Download', ['class' => 'btn btn-primary']) ?>
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
                        <?= Html::a('Sub Cost', null, [
                            'class' => 'btn btn-primary',
                            'data-title' => 'Sub Cost',
                            'data-url' => '/finance-sub-cost/create?bill_id=' . $model->bill_id,
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
                        'id' => 'data-list',
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
                                'label' => 'Sub Cost',
                                'attribute' => 'adjust_cost',
                                'value' => 'adjust_cost',
                                'contentOptions' => function ($model) {
                                    $model = (object)$model;
                                    if ($model->adjust_cost >0 ) {
                                        return ['class' => 'bg-danger'];
                                    }
                                }
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
    <!-- system cost -->
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-body">
                    <p>
                    <h4>System Cost</h4>
                    </p>
                    <?php
                    $campaignBillColumns = [
                        [
                            // 'label' => 'start_time',
                            'attribute' => 'bill.period',
                            'pageSummary' => 'Summary',
                        ],
                        [
                            'label' => 'Channel',
                            'attribute' => 'channel_id',
//                                'value' => 'channel_id',
                            'value' => 'channel.username',
                            'filter' => false,
                        ],
                        [
                            // 'label' => 'campaign_id',
                            'attribute' => 'campaign_id',
                            'value' => 'campaign_id',
                        ],
                        [
                            // 'label' => 'time_zone',
                            'attribute' => 'campaign_name',
                            'value' => 'campaign.name',
                        ],
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
                            'contentOptions' => function ($model) {
                                $model = (object)$model;
                                $cvr = 0;
                                if ($model->clicks > 0) {
                                    $cvr = round(($model->installs / $model->clicks) * 100, 2);
                                }
                                if ($cvr > 2) {
                                    return ['class' => 'bg-danger'];
                                }
                            }
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
                            'label' => 'Pending Cost',
                            'attribute' => 'pending_cost',
//                            'value' => 'pending_cost',
                            'value' => function ($model) {
                                return $model->deduction_cost > 0 ? 0.00 : $model->pending_cost;
                            },
                            'pageSummary' => true,
                        ],
                        [
                            'label' => 'Pending Revenue',
                            'attribute' => 'pending_revenue',
//                            'value' => 'pending_revenue',
                            'value' => function ($model) {
                                return $model->deduction_cost > 0 ? 0.00 : $model->pending_revenue;
                            },
                            'pageSummary' => true,
                        ],
                        [
                            'label' => 'Deduction Cost',
                            'attribute' => 'deduction_cost',
                            'value' => 'deduction_cost',
                            'pageSummary' => true,
                        ],
                        [
                            'label' => 'Deduction Revenue',
                            'attribute' => 'deduction_revenue',
                            'value' => 'deduction_revenue',
                            'pageSummary' => true,
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

                    ];
                    echo ExportMenu::widget([
                        'dataProvider' => $campaignBill,
                        'columns' => $campaignBillColumns,
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
                        'dataProvider' => $campaignBill,
                        'pjax' => true,
                        'showPageSummary' => true,
                        'filterModel' => $searchModel,
                        'columns' => $campaignBillColumns,
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
                    <h4>Historic Cost</h4>
                    </p>
                    <?php
                    $confirmedColumns = [
                        [
                            'label' => 'Channel',
                            'attribute' => 'channel_id',
//                                'value' => 'channel_id',
                            'value' => 'channel.username',
                        ],
                        [
                            // 'label' => 'campaign_id',
                            'attribute' => 'campaign_id',
                            'value' => 'campaign_id',
                        ],
                        [
                            'label' => 'Campaign Name',
                            'attribute' => 'campaign_id',
                            'value' => 'campaign.campaign_name',
                        ],
                        [
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
                            'attribute' => 'end_date',
                            'value' => function ($model) {
                                $format = 'Y-m-d';
                                $date = new DateTime();
                                $date->setTimezone(new DateTimeZone('Etc/GMT-8'));
                                $date->setTimestamp($model->end_date);
                                return $date->format($format);
                            },

                        ],
//                        [
////                                'label' => 'clicks',
//                            'attribute' => 'clicks',
//                            'value' => 'clicks',
//                            'pageSummary' => true,
//                        ],
                        [
//                                'label' => 'installs',
                            'attribute' => 'installs',
                            'value' => 'installs',
                            'pageSummary' => true,
                        ],
                        [
//                             'label' => 'pay_out',
                            'attribute' => 'pay_out',
                            'value' => 'pay_out',
                            'pageSummary' => true,
                        ],
                        [
                            'label' => 'cost',
                            'attribute' => 'cost',
                            'value' => 'cost',
                            'pageSummary' => true,
                        ],
                        [
//                                'label' => 'revenue',
                            'attribute' => 'revenue',
                            'value' => 'revenue',
                            'pageSummary' => true,
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
                    ];
                    echo ExportMenu::widget([
                        'dataProvider' => $confirmList,
                        'columns' => $confirmedColumns,
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
                        'dataProvider' => $confirmList,
                        'columns' => $confirmedColumns,
                        'showPageSummary' => true,
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
                    <?php
                    $pendingColumns = [
                        [
                            'label' => 'ID',
                            'attribute' => 'id',
                            'value' => 'id',
                        ],
                        [
//                                'label' => 'Channel Name',
                            'attribute' => 'channel_id',
                            'value' => 'channel_id',
                        ],
                        [
                            'label' => 'Channel Name',
                            'attribute' => 'channel_id',
//                                'value' => 'channel_id',
                            'value' => function($pendingList){
                                return $pendingList->channel->username;
                            }
                        ],
                        [
                            // 'label' => 'campaign_id',
                            'attribute' => 'campaign_id',
                            'value' => 'campaign_id',
                        ],
                        [
                            'label' => 'Campaign Name',
                            'attribute' => 'campaign_id',
                            'value' => function($pendingList){
                                return $pendingList->campaign->campaign_name;
                            }
//                                'value' => 'campaign_id',
                        ],
                        [
                            // 'label' => 'start_time',
                            'attribute' => 'start_date',
                            'value' => 'start_date',
                            'format' => 'datetime',
                        ],
                        [
                            'attribute' => 'end_date',
                            'value' => 'end_date',
                            'format' => 'datetime',
                        ],
                        [
//                            'label' => 'installs',
                            'attribute' => 'installs',
                            'value' => 'installs',
                            'pageSummary' => true,
                        ],
                        [
//                            'label' => 'cost',
                            'attribute' => 'cost',
                            'value' => 'cost',
                            'pageSummary' => true,
                        ],
                        [
//                            'label' => 'revenue',
                            'attribute' => 'revenue',
                            'value' => 'revenue',
                            'pageSummary' => true,
                        ],
                        [
//                            'label' => 'margin',
                            'attribute' => 'margin',
                            'value' => 'margin',
                        ],
                        [
//                            'label' => 'adv',
                            'attribute' => 'adv',
                            'value' => 'adv',
                        ],
                        [
//                            'label' => 'pm',
                            'attribute' => 'pm',
                            'value' => 'pm',
                        ],
                        [
//                            'label' => 'bd',
                            'attribute' => 'bd',
                            'value' => 'bd',
                        ],
                        [
//                            'label' => 'note',
                            'attribute' => 'note',
                            'value' => 'note',
                        ],
                    ];
                    echo ExportMenu::widget([
                        'dataProvider' => $pendingList,
                        'columns' => $pendingColumns,
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
                        'dataProvider' => $pendingList,
                        'columns' => $pendingColumns,
                        'showPageSummary' => true,
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
                    <?php
                    $deductionColumns =  [
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
                            'label' => 'Campaign Name',
                            'attribute' => 'campaign_id',
                            'value' => 'campaign.campaign_name'
//                                'value' => 'campaign_id',
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

//                        [
////                             'label' => ''
//                            'attribute' => 'deduction_value',
//                            'value' => 'deduction_value',
//                        ],
                        [
//                             'label' => ''
                            'attribute' => 'deduction_value',
                            'value' => 'deduction_value',
                            'class'=>'kartik\grid\EditableColumn',
                            'editableOptions'=>function ($model, $key, $index) {
                                return [
//                                    'header' => 'employment_period',
                                    'asPopover' => false,
                                    'inputType' => Editable::INPUT_TEXTAREA,
                                    'formOptions' => ['action' => ['/finance-deduction/update?id='.$key]],
                                ];
                            }
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
                    ];
                    echo ExportMenu::widget([
                        'dataProvider' => $deductionList,
                        'columns' => $deductionColumns,
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
                        'dataProvider' => $deductionList,
                        'columns' => $deductionColumns,
                        'showPageSummary' => true,
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
                    <?php
                    $compensationColumns =  [
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
                            'format' => 'datetime',
                        ],
                        [
                            // 'label' => 'system_revenue',
                            'attribute' => 'deduction_revenue',
                            'value' => 'deduction.deduction_revenue',
                            'pageSummary' => true,
                        ],
                        [
                            // 'label' => 'system_revenue',
                            'attribute' => 'deduction_cost',
                            'value' => 'deduction.deduction_cost',
                            'pageSummary' => true,
                        ],
                        [
                            // 'label' => 'billable_cost',
                            'attribute' => 'system_cost',
                            'value' => 'deduction.cost',
                            'pageSummary' => true,
                        ],
                        [
                            // 'label' => 'billable_cost',
                            'attribute' => 'system_revenue',
                            'value' => 'deduction.revenue',
                            'pageSummary' => true,
                        ],
                        [
                            // 'label' => 'billable_cost',
                            'attribute' => 'billable_cost',
                            'value' => 'billable_cost',
                            'pageSummary' => true,
                        ],
                        [
                            // 'label' => 'billable_cost',
                            'attribute' => 'billable_cost',
                            'value' => 'billable_cost',
                            'pageSummary' => true,
                        ],
                        [
//                             'label' => 'billable_revenue',
                            'attribute' => 'billable_revenue',
                            'value' => 'billable_revenue',
                            'pageSummary' => true,
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
                            'pageSummary' => true,
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
                    ];
                    echo ExportMenu::widget([
                        'dataProvider' => $compensationList,
                        'columns' => $compensationColumns,
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
                        'dataProvider' => $compensationList,
                        'pjax' => true,
                        'showPageSummary' => true,
                        'columns' => $compensationColumns,
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
                    <?php
                    $costColumns =  [
                        [
                            // 'label' => 'cost',
                            'attribute' => 'cost',
                            'value' => 'cost',
                        ],
                        [
                            // 'label' => 'cost',
                            'attribute' => 'revenue',
                            'value' => 'revenue',
                        ],
                        [
                            'attribute' => 'note',
                            'value' => 'note',
                        ],
                    ];
                    echo ExportMenu::widget([
                        'dataProvider' => $costList,
                        'columns' => $costColumns,
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
                        'dataProvider' => $costList,
                        'columns' => $costColumns,
                        'showPageSummary' => true,
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- sub cost-->
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-body">
                    <p>
                    <h4>Sub Cost</h4>
                    </p>
                    <?php
                    $subCostColumns =  [
                        [
                            // 'label' => 'cost',
                            'attribute' => 'cost',
                            'value' => 'cost',
                            'pageSummary' => true,
                        ],
                        [
                            // 'label' => 'cost',
                            'attribute' => 'revenue',
                            'value' => 'revenue',
                            'pageSummary' => true,
                        ],
                        [
                            'attribute' => 'note',
                            'value' => 'note',
                        ],
                    ];
                    echo ExportMenu::widget([
                        'dataProvider' => $costList,
                        'columns' => $costColumns,
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
                        'dataProvider' => $subCostList,
                        'columns' => $subCostColumns,
                        'showPageSummary' => true,
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
                    <?php
                    $prepaymentColumns =  [
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

                    ];
                    echo ExportMenu::widget([
                        'dataProvider' => $prepaymentList,
                        'columns' => $prepaymentColumns,
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
                        'dataProvider' => $prepaymentList,
                        'columns' => $prepaymentColumns,
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