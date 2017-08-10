<?php


/* @var $this yii\web\View */
use kartik\grid\GridView;

/* @var $searchModel backend\models\FinanceAdvertiserBillTermSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Advertiser Receivable';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="finance-advertiser-bill-month-index"></div>
<?php  echo $this->render('_search', ['model' => $searchModel]); ?>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body">
                <div class="finance-advertiser-bill-month-index">

                    <?php
                    $summary_columns = [
                        [
                            // 'label' => 'invoice_id',
                            'attribute' => 'pending_billing',
                            'value' => function ($model) {
                                $model = (object)$model;
                                return $model->pending_billing.'/'.$model->count_pending;
                            },
                        ],
                        [
                            // 'label' => 'invoice_id',
                            'attribute' => 'bd_leader_approval',
                            'value' => function ($model) {
                                $model = (object)$model;
                                return $model->bd_leader_approval.'/'.$model->count_bd_leader_approval;
                            },
                        ],
                        [
                            // 'label' => 'invoice_id',
                            'attribute' => 'bd_leader_reject',
                            'value' => function ($model) {
                                $model = (object)$model;
                                return $model->bd_leader_reject.'/'.$model->count_bd_leader_reject;
                            },
                        ],
                        [
                            // 'label' => 'invoice_id',
                            'attribute' => 'finance_approval',
                            'value' => function ($model) {
                                $model = (object)$model;
                                return $model->finance_approval.'/'.$model->count_finance_approval;
                            },
                        ],
                        [
                            // 'label' => 'invoice_id',
                            'attribute' => 'finance_reject',
                            'value' => function ($model) {
                                $model = (object)$model;
                                return $model->finance_reject.'/'.$model->count_finance_reject;
                            },
                        ],
                        [
                            // 'label' => 'invoice_id',
                            'attribute' => 'receivable',
                            'value' => function ($model) {
                                $model = (object)$model;
                                return $model->receivable.'/'.$model->count_receivable;
                            },
                        ],
                        [
                            // 'label' => 'invoice_id',
                            'attribute' => 'received',
                            'value' => function ($model) {
                                $model = (object)$model;
                                return $model->received.'/'.$model->count_received;
                            },
                        ],
                        [
                            // 'label' => 'invoice_id',
                            'attribute' => 'overdue',
                            'value' => function ($model) {
                                $model = (object)$model;
                                return $model->overdue.'/'.$model->count_overdue;
                            },
                        ],
                    ];

                    echo GridView::widget([
                        'dataProvider' => $summary,
                        'columns' => $summary_columns,
                    ]);
                    ?>
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
                                                      <li><a data-pjax="0" href="/finance-advertiser-bill-term/edit?bill_id=' . $model->bill_id . '" >Edit</a></li>
                                                      <li><a data-retreat="0" data-title="' . $model->invoice_id . '" data-url="/finance-advertiser-bill-term/retreat?id=' . $model->bill_id . '">Retreat</a></li>
                                                      </ul></div>';
                                    },
                                ],
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
                                // 'label' => 'invoice_id',
                                'attribute' => 'invoice_id',
                                'value' => 'invoice_id',
                            ],
                            [
                                // 'label' => 'adv_id',
                                'attribute' => 'adv_name',
                                'value' => 'adv.username',
                            ],
                            [
                                // 'label' => 'adv_id',
                                'attribute' => 'payment_term',
                                'value' => 'adv.payment_term',
                                'filter' => false
                            ],
                            [
                                // 'label' => 'time_zone',
                                'attribute' => 'time_zone',
                                'value' => function ($model) {
                                    return ModelsUtil::getTimezone($model->time_zone);
                                },
//                                'filter' => ModelsUtil::timezone,
                                'filter' => false,
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
                                'attribute' => 'bd',
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
</div>
<?php
$this->registerJsFile(
    '@web/js/finance-pending-campaign.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>