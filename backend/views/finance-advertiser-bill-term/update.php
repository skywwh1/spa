<?php

use kartik\file\FileInput;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use kartik\export\ExportMenu;
use kartik\editable\Editable;

/* @var $this yii\web\View */
/* @var $model backend\models\FinanceAdvertiserBillTerm */
/* @var $receivableList yii\data\ActiveDataProvider */
/* @var $systemRevenueList yii\data\ActiveDataProvider */
/* @var $pendingList yii\data\ActiveDataProvider */
/* @var $deductionList yii\data\ActiveDataProvider */
/* @var $addRevenueList yii\data\ActiveDataProvider */
/* @var $prepaymentList yii\data\ActiveDataProvider */
/* @var $searchModel backend\models\FinanceAdvertiserCampaignBillTermSearch */

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
                    <?php
                    if(\Yii::$app->user->can('admin')){
                        echo $form->field($model, 'status', [
                            'labelOptions' => ['class' => 'col-sm-2 control-label'],
                            'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                        ])->dropDownList(ModelsUtil::receivable_status);
                    }else{
                        echo $form->field($model, 'status', [
                            'labelOptions' => ['class' => 'col-sm-2 control-label'],
                            'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                        ])->dropDownList(ModelsUtil::receivable_status_bd);
                    }
                    ?>
                    <?= $form->field($model, 'update_time', [
                        'labelOptions' => ['class' => 'col-sm-2 control-label'],
                        'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                    ])->textInput(['readonly' => 'readonly']) ?>
                    <?= $form->field($advertiser, 'address', [
                        'labelOptions' => ['class' => 'col-sm-2 control-label'],
                        'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                    ])->textInput(['readonly' => 'readonly']) ?>
                    <?= $form->field($advertiser, 'beneficiary_name', [
                        'labelOptions' => ['class' => 'col-sm-2 control-label'],
                        'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                    ])->textInput(['readonly' => 'readonly']) ?>
                    <?= $form->field($advertiser, 'account_nu_iban', [
                        'labelOptions' => ['class' => 'col-sm-2 control-label'],
                        'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                    ])->textInput(['readonly' => 'readonly']) ?>
                    <?= $form->field($advertiser, 'bank_name', [
                        'labelOptions' => ['class' => 'col-sm-2 control-label'],
                        'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                    ])->textInput(['readonly' => 'readonly']) ?>
                    <?= $form->field($advertiser, 'bank_address', [
                        'labelOptions' => ['class' => 'col-sm-2 control-label'],
                        'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                    ])->textInput(['readonly' => 'readonly']) ?>
                    <?= $form->field($advertiser, 'swift', [
                        'labelOptions' => ['class' => 'col-sm-2 control-label'],
                        'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                    ])->textInput(['readonly' => 'readonly']) ?>
                    <?= $form->field($advertiser, 'invoice_title', [
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
                    <div class="col-lg-1">
                        <?= Html::button('Export', ['class' => 'btn btn-primary']) ?>
                    </div>
                    <div class="col-lg-1">
                        <?php
                        Modal::begin([
                            'header' => 'Upload File',
                            'toggleButton' => [
                                'label' => 'Upload', 'class' => 'btn btn-primary'
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
                        <?= Html::button('Download', ['class' => 'btn btn-primary']) ?>
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
                        <?= Html::a('Sub Revenue', null, [
                            'class' => 'btn btn-primary',
                            'data-title' => 'Sub Revenue',
                            'data-url' => '/finance-sub-revenue/create?bill_id=' . $model->bill_id,
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
    <!-- Receivable -->
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-body">
                    <p>
                    <h4>Receivable</h4>
                    </p>
                    <?= GridView::widget([
                        'dataProvider' => $receivableList,
                        'layout' => '{items}',
                        'pjax' => true,
                        'id' => 'data-list',
                        'columns' => [
                            [
                                'label' => 'Payment Term',
                                'value' => function ($model) {
                                    return ModelsUtil::getPaymentTerm($model->adv->payment_term);
                                }
                            ],
                            [
                                // 'label' => 'invoice_id',
                                'attribute' => 'status',
                                'value' => function ($model) {
                                    return ModelsUtil::getReceivableStatus($model->status);
                                },
                                'filter' => ModelsUtil::receivable_status,
                            ],
                            [
                                'label' => 'System Revenue',
                                'attribute' => 'revenue',
                                'value' => 'revenue',
                            ],
                            [
                                'attribute' => 'add_historic',
                                'value' => 'add_historic',
                            ],
                            [
                                'attribute' => 'pending',
                                'value' => 'pending',
                            ],
                            [
                                'attribute' => 'deduction',
                                'value' => 'deduction',
                            ],
                            [
                                'attribute' => 'add_revenue',
                                'value' => 'add_revenue',
                            ],
                            [
                                'attribute' => 'final_revenue',
                                'value' => 'final_revenue',
                            ],
                            [
                                'label' => 'Sub Revenue',
                                'attribute' => 'adjust_revenue',
                                'value' => 'adjust_revenue',
                                'contentOptions' => function ($model) {
                                    $model = (object)$model;
                                    if ($model->adjust_revenue >0 ) {
                                        return ['class' => 'bg-danger'];
                                    }
                                }
                            ],
                            [
                                'attribute' => 'actual_margin',
                                'value' => 'actual_margin',
                            ],
                            [
                                'attribute' => 'received_amount',
                                'value' => 'received_amount',
                            ],
                            [
                                'attribute' => 'receivable',
                                'value' => 'receivable',
                            ],
                            [
                                'attribute' => 'prepayment',
                                'value' => 'prepayment',
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
                    <?php
                    $systemColumns = [
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
                                      <li><a data-view="0" data-title="Add Pending" data-url="/finance-pending/add-adv-by-adv?adv_name=' . $model->bill->adv->username . '&period='.$model->bill->period.'&channel_name='.$model->channel_name.'">Add Pending</a></li>
                                      <li><a data-view="0" data-title="Add Discount" data-url="/finance-deduction/add-discount-by-adv?campaign_id=' . $model->campaign_id . '&pending_id='.$model->pending_id.'&period='.$model->bill->period.'&channel_name='.$model->channel_name.'">Add Discount</a></li>
                                      <li><a data-view="0" data-title="Add Install Deduction" data-url="/finance-deduction/add-install-by-adv?campaign_id=' . $model->campaign_id . '&pending_id='.$model->pending_id.'&period='.$model->bill->period.'&channel_name='.$model->channel_name.'">Add Install Deduction</a></li>
                                      <li><a data-view="0" data-title="Add Fine" data-url="/finance-deduction/add-fine-by-adv?campaign_id=' . $model->campaign_id . '&pending_id='.$model->pending_id.'&period='.$model->bill->period.'&channel_name='.$model->channel_name.'">Add Fine</a></li>
                                      </ul></div>';
                                },
                            ],
                        ],
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
                            'attribute' => 'campaign_name',
                            'value' => 'campaign.name',
                        ],
                        [
                            'label' => 'Channel',
                            'attribute' => 'channel_name',
//                            'value' => 'channel.username',
                        ],
                        [
//                             'label' => 'clicks',
                            'attribute' => 'clicks',
                            'value' => 'clicks',
                            'pageSummary' => true,
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
                            'pageSummary' => true,
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
                            'pageSummary' => true,
                        ],
                        [
                            'label' => 'Margin',
                            'attribute' => 'redirect_revenue',
                            'value' => function ($model) {
                                return $model->revenue == 0 ? 0.00 : round((($model->revenue - $model->cost) / $model->revenue), 2);
                            },
                            'filter' => false,
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
                            'value' => 'bill.adv.username',
                        ],
//                        [
//                            'label' => 'BD',
//                            'value' => 'bill.adv.bd0.username',
//                        ],
                        [
                            'label' => 'OM',
                            'value' => 'channel.om0.username',
                        ],
                    ];
                    echo ExportMenu::widget([
                        'dataProvider' => $systemRevenueList,
                        'columns' => $systemColumns,
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
                        'dataProvider' => $systemRevenueList,
                        'pjax' => true,
                        'layout' => '{items}',
                        'showPageSummary' => true,
                        'filterModel' => $searchModel,
                        'columns' => $systemColumns,
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
    <!-- historic revenue -->
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-body">
                    <p>
                    <h4>Historic Revenue</h4>
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
                            'class' => 'kartik\grid\ActionColumn',
                            'template' => '{all}',
                            'header' => 'Action',
                            'buttons' => [
                                'all' => function ($url, $model, $key) {
                                    return '<div class="dropdown">
                                      <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Actions
                                      <span class="caret"></span></button>
                                      <ul class="dropdown-menu">
                                      <li><a data-view="0" data-title="Confirm ' . $model->id . '" data-url="/finance-pending/update?id=' . $model->id . '">Confirm</a></li>
                                      <li><a data-view="0" data-title="Update Pending ' . $model->id . '" data-url="/finance-pending/update-pending?id=' . $model->id . '">Update</a></li>
                                      </ul></div>';
                                },
                            ],
                        ],
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
                            'label' => 'installs',
                            'attribute' => 'installs',
                            'value' => 'installs',
                            'pageSummary' => true,
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
                            'label' => 'Note',
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
    <!-- Deduction -->
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-body">
                    <p>
                    <h4>Deduction</h4>
                    </p>
                    <?php
                    $deductionColumns = [
//                        [
//                            'class' => 'kartik\grid\ActionColumn',
//                            'template' => '{all}',
//                            'header' => 'Action',
//                            'buttons' => [
//                                'all' => function ($url, $model, $key) {
//                                    return '<div class="dropdown">
//                                      <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Actions
//                                      <span class="caret"></span></button>
//                                      <ul class="dropdown-menu">
//
//                                      <li><a data-view="0" data-title="View deduction ' . $model->id . '" data-url="/finance-deduction/view?id=' . $model->id . '">View</a></li>
//                                      <li><a data-view="0" data-title="Confirm deduction ' . $model->id . '" data-url="/finance-deduction/update?id=' . $model->id . '">Confirm</a></li>'
//                                    . '</ul>
//                                    </div>';
//                                },
//                            ],
//                        ],
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

                        [
//                             'label' => ''
                            'attribute' => 'deduction_value',
                            'value' => 'deduction_value',
                            'class'=>'kartik\grid\EditableColumn',

//                            'editableOptions'=>[
//                                'asPopover' => false,
//                                'inputType'=>Editable::INPUT_TEXTAREA,
//                                'options' => [
//                                    'rows' => 4,
//                                ],
//                            ],
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
                            'pageSummary' => true,
                        ],
                        [
//                                'label' => 'deduction_revenue',
                            'attribute' => 'deduction_revenue',
                            'value' => 'deduction_revenue',
                            'pageSummary' => true,
                        ],
                        [
                            'attribute' => 'revenue',
                            'value' => 'revenue',
                            'pageSummary' => true,
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
                        [
                            'label' => 'Note',
                            'attribute' => 'note',
                            'value' => 'note',
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
                        'pjax' => true,
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
                    <?php
                    $addRevenueColumns = [
                        [
                            'attribute' => 'revenue',
                            'value' => 'revenue',
                            'pageSummary' => true,
                        ],
                        [
                            'attribute' => 'cost',
                            'value' => 'cost',
                            'pageSummary' => true,
                        ],
                        [
                            'attribute' => 'note',
                        ],
                    ];
                    echo ExportMenu::widget([
                        'dataProvider' => $addRevenueList,
                        'columns' => $addRevenueColumns,
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
                        'dataProvider' => $addRevenueList,
                        'showPageSummary' => true,
                        'columns' => $addRevenueColumns
                    ]); ?>

                </div>
            </div>
        </div>
    </div>
    <!-- Sub revenue -->
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-body">
                    <p>
                    <h4>Sub revenue</h4>
                    </p>
                    <?php
                    $subRevenueColumns = [
                        [
                            'attribute' => 'revenue',
                            'value' => 'revenue',
                            'pageSummary' => true,
                        ],
                        [
                            'attribute' => 'cost',
                            'value' => 'cost',
                            'pageSummary' => true,
                        ],
                        [
                            'attribute' => 'note',
                        ],
                    ];
                    echo ExportMenu::widget([
                        'dataProvider' => $subRevenueList,
                        'columns' => $subRevenueColumns,
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
                        'dataProvider' => $subRevenueList,
                        'showPageSummary' => true,
                        'columns' => $subRevenueColumns
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
                <?php
                $prepaymentColumns = [
                    [
                        // 'label' => 'prepayment',
                        'attribute' => 'prepayment',
                        'value' => 'prepayment',
                        'pageSummary' => true,
                    ],
                    [
                        'label' => 'note',
                        'attribute' => 'note',
                        'value' => 'note',
                        'format' => 'ntext',
                    ],
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
                <div class="box-body">
                    <?= GridView::widget([
                        'dataProvider' => $prepaymentList,
                        'showPageSummary' => true,
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
Modal::end(); ?>