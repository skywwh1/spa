<?php


/* @var $this yii\web\View */
use kartik\grid\GridView;

/* @var $searchModel backend\models\FinanceChannelBillTermSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Channel Payable';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div id="nav-menu" data-menu="finance-channel-bill-term-index"></div>
    <div class="row">
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body">
                <div class="finance-channel-bill-term-index">

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'pjax' => true,
                        'id' => 'channel-payable-list',
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
                                              <li><a data-pjax="0" href="/finance-channel-bill-term/edit?bill_id=' . $model->bill_id . '" >Edit</a></li>
                                              <li><a data-retreat="0" data-title="' . $model->invoice_id . '" data-url="/finance-channel-bill-term/retreat?id=' . $model->bill_id . '">Retreat</a></li>
                                              </ul></div>';
                                    },
                                ],
                            ],

                            [
                                // 'label' => 'bill_id',
                                'attribute' => 'status',
                                'value' => function ($model) {
                                    return ModelsUtil::getPayableStatus($model->status);
                                },
                            ],

                            [
                                // 'label' => 'bill_id',
                                'attribute' => 'bill_id',
                                'value' => 'bill_id',
                            ],
                            [
                                'label' => 'Payment Term',
                                'value' => function ($model) {
                                    return ModelsUtil::getPaymentTerm($model->channel->payment_term);
                                }

                            ],

//                            [
//                                // 'label' => 'bill_id',
//                                'attribute' => 'bill_id',
//                                'value' => 'bill_id',
//                            ],
                            ['label' => 'cost',
                                'attribute' => 'cost',
                                'value' => 'cost',
                            ],
                            [
                                // 'label' => 'invoice_id',
                                'attribute' => 'invoice_id',
                                'value' => 'invoice_id',
                            ],
                            [
                                // 'label' => 'period',
                                'attribute' => 'period',
                                'value' => 'period',
                            ],
                            [
                                // 'label' => 'channel_id',
                                'attribute' => 'channel_name',
                                'value' => 'channel.username',
                            ],
                            [
                                'label' => 'OM',
//                                'attribute' => 'channel_id',
                                'value' => 'channel.om0.username',
                            ],
                            [
                                // 'label' => 'time_zone',
                                'attribute' => 'time_zone',
                                'value' => function ($model) {
                                    return ModelsUtil::getTimezone($model->time_zone);
                                },
                                'filter' => ModelsUtil::timezone,
                            ],
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
                            // 'label' => 'deduction',
                            // 'attribute' => 'deduction',
                            // 'value' => 'deduction',
                            // ],
                            //[
                            // 'label' => 'compensation',
                            // 'attribute' => 'compensation',
                            // 'value' => 'compensation',
                            // ],
                            //[
                            // 'label' => 'add_cost',
                            // 'attribute' => 'add_cost',
                            // 'value' => 'add_cost',
                            // ],
                            //[
                            // 'label' => 'final_cost',
                            // 'attribute' => 'final_cost',
                            // 'value' => 'final_cost',
                            // ],
                            //[
                            // 'label' => 'actual_margin',
                            // 'attribute' => 'actual_margin',
                            // 'value' => 'actual_margin',
                            // ],
                            //[
                            // 'label' => 'paid_amount',
                            // 'attribute' => 'paid_amount',
                            // 'value' => 'paid_amount',
                            // ],
                            //[
                            // 'label' => 'payable',
                            // 'attribute' => 'payable',
                            // 'value' => 'payable',
                            // ],
                            //[
                            // 'label' => 'apply_prepayment',
                            // 'attribute' => 'apply_prepayment',
                            // 'value' => 'apply_prepayment',
                            // ],
                            //[
                            // 'label' => 'balance',
                            // 'attribute' => 'balance',
                            // 'value' => 'balance',
                            // ],
                            //[
                            // 'label' => 'status',
                            // 'attribute' => 'status',
                            // 'value' => 'status',
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
<?php
$this->registerJsFile(
    '@web/js/finance-pending-campaign.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>