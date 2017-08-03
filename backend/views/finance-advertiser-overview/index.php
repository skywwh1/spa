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
                                              <li><a data-view="0" data-url="/finance-advertiser-overview/view?bill_id=' . $model->bill_id  . '&cha_paid=' . $model->cha_paid . '&cha_payable=' . $model->cha_payable.'">View</a></li>
                                              <li><a data-pjax="0" href="/finance-advertiser-bill-term/edit?bill_id=' . $model->bill_id . '" >Detail</a></li>
                                              </ul></div>';
                                    },
                                ],
                            ],

                            [
                                'attribute' => 'status',
                                'value' => function ($model) {
                                    return ModelsUtil::getReceivableStatus($model->status);
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
                                'filter' => false,
                                'value' => function ($model){
                                    if ($model->cost>0){
                                        return $model->cha_payable == 0 ? 0.00 :$model->cha_payable;
                                    }
                                    return 0;
                                }
                            ],
                            [
                                'attribute' => 'cha_paid',
                                'filter' => false,
                                'value' => function ($model){
                                    return $model->cha_paid == 0 ? 0.00 :$model->cha_paid;
                                }
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
                                'value' => function ($model){
                                    return $model->status == 7 ? $model->receivable :0;
                                },
                                'filter' => false,
                            ],
                            [
                                'attribute' => 'actual_margin',
                                'filter' => false,
                                'value' => function ($model){
                                    return $model->receivable == 0 ? 0.00 : round((($model->receivable - $model->cha_payable) / $model->receivable)*100, 2).'%';
                                }
                            ],
                            [
                                'label' => 'cash_flow',
                                'attribute' => 'cash_flow',
                                'value' => function ($model){
                                    return $model->final_revenue-$model->cha_paid;
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
<?php
$this->registerJsFile(
    '@web/js/deliver.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>
<?php \yii\bootstrap\Modal::begin([
    'id' => 'deliver-modal',
    'size' => 'modal-lg',
//    'header' =>'00',
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false,
    ],
]);

echo '<div id="deliver-detail-content"></div>';

\yii\bootstrap\Modal::end(); ?>