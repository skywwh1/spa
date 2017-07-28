<?php
/* @var $this yii\web\View */
use kartik\grid\GridView;

/* @var $searchModel backend\models\FinanceAdvertiserBillTermSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Advertiser Overview';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div id="nav-menu" data-menu="finance-advertiser-overview-index"></div>
    <div class="row">
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body">
                <div class="finance-advertiser-overview-index">

                    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'pjax' => true,
                        'id' => 'advertiser-overview-list',
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
                                              <li><a data-view="0" data-url="/finance-channel-overview/view?bill_id=' . $model->bill_id  . '">View</a></li>
                                              <li><a data-pjax="0" href="/finance-advertiser-bill-term/edit?bill_id=' . $model->bill_id . '" >Detail</a></li>
                                              </ul></div>';
                                    },
                                ],
                            ],

                            [
                                'attribute' => 'status',
                                'value' => function ($model) {
                                    return ModelsUtil::getPayableStatus($model->status);
                                },
                                'filter' => false,
                            ],

                            [
                                'attribute' => 'invoice_id',
                                'value' => 'invoice_id',
                                'filter' => false,
                            ],
                            [
                                // 'label' => 'adv_id',
                                'attribute' => 'adv_name',
                                'value' => 'adv.username',
                                'filter' => false,
                            ],
                            [
                                'label' => 'cost',
                                'attribute' => 'report_cost',
                                'value' => 'report_cost',
                                'filter' => false,
                            ],
                            [
                                'attribute' => 'cha_payable',
                                'value' => 'cha_payable',
                                'filter' => false,
                            ],
                            [
                                'attribute' => 'cha_paid',
                                'value' => 'cha_paid',
                                'filter' => false,
                            ],
                            [
                                'label' => 'revenue',
                                'attribute' => 'revenue',
                                'value' => 'revenue',
                                'filter' => false,
                            ],
                            [
                                'attribute' => 'receivable',
                                'value' => 'receivable',
                                'filter' => false,
                            ],
                            [
                                'label' => 'received',
                                'attribute' => 'final_revenue',
                                'value' => 'final_revenue',
                                'filter' => false,
                            ],
                            [
                                'attribute' => 'actual_margin',
                                'value' => 'actual_margin',
                                'filter' => false,
                            ],
                            [
                                'label' => 'cash_flow',
                                'attribute' => 'cash_flow',
                                'value' => function ($model){
                                    return $model->cha_paid-$model->cost;
                                }
                            ],
                            [
                                'attribute' => 'period',
                                'value' => 'period',
                                'filter' => false,
                            ],
                            [
                                'attribute' => 'bd',
                                'value' => 'adv.bd0.username',
                                'filter' => false,
                            ],
                            [
                                'label' => 'PM',
                                'value' => 'adv.pm0.username',
                                'filter' => false,
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>