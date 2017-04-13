<?php


/* @var $this yii\web\View */
use kartik\grid\GridView;

/* @var $searchModel backend\models\FinanceAdvertiserBillTermSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Advertiser Receivable';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="finance-advertiser-bill-month-index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body">
                <div class="finance-advertiser-bill-month-index">

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <p>
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
                                            return '<div class="dropdown">
                                      <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Actions
                                      <span class="caret"></span></button>
                                      <ul class="dropdown-menu">

                                      <li><a data-delete="0" data-title="' . $this->title . ' ' . $model->invoice_id . '" data-url="/finance-compensation/delete?id=' . $model->invoice_id . '">Edit</a></li>
                                      <li><a data-view="0" data-title="Update Compensation ' . $model->invoice_id . '" data-url="/finance-compensation/update?id=' . $model->invoice_id . '">Retreat</a></li>
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
</div>