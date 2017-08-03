<?php
/* @var $this yii\web\View */
use kartik\grid\GridView;

/* @var $searchModel backend\models\FinanceChannelBillTermSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Channel Overview';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div id="nav-menu" data-menu="finance-channel-overview-index"></div>
    <div class="row">
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body">
                <div class="finance-channel-overview-index">

                    <?php  echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'pjax' => true,
                        'id' => 'channel-overview-list',
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
                                              <li><a data-view="0" data-url="/finance-channel-overview/view?bill_id=' . $model->bill_id  . '&adv_received' . $model->adv_received  . '&adv_receivable=' . $model->adv_receivable  . '">View</a></li>
                                              <li><a data-pjax="0" href="/finance-channel-bill-term/edit?bill_id=' . $model->bill_id . '" >Edit</a></li>
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
                                'attribute' => 'bill_id',
                                'value' => 'bill_id',
                                'filter' => false,
                            ],
                            [
                                'attribute' => 'channel_name',
                                'value' => 'channel.username',
                                'filter' => false,
                            ],
                            [
                                'attribute' => 'cost',
                                'value' => 'cost',
                                'filter' => false,
                            ],
                            [
                                 'attribute' => 'payable',
                                 'value' => 'payable',
                                'filter' => false,
                             ],
                            [
                                'attribute' => 'paid',
                                'value' => function ($model){
                                    return $model->status == 7 ? $model->payable :0;
                                },
                                'filter' => false,
                            ],
                            [
                                'label' => 'System Revenue',
                                'attribute' => 'report_revenue',
                                'value' => 'report_revenue',
                            ],
                            [
                                'label' => 'Adv Receivable',
                                'attribute' => 'adv_receivable',
                                'value' => function ($model){
                                    return $model->adv_receivable == 0 ? 0.00 :$model->adv_receivable;
                                }
                            ],
                            [
                                'label' => 'Adv Received',
                                'attribute' => 'adv_received',
                                'value' => function ($model){
                                    return $model->adv_received == 0 ? 0.00 :$model->adv_received;
                                }
                            ],
                            [
                                'attribute' => 'actual_margin',
                                'filter' => false,
                                'value' => function($model){
                                    return $model->adv_receivable == 0 ? 0.00 : round((($model->adv_receivable - $model->payable) / $model->adv_receivable)*100, 2).'%';
                                }
                            ],
                            [
                                'label' => 'cash_flow',
                                'attribute' => 'cash_flow',
                                'value' => function ($model){
                                    return $model->adv_received-$model->final_cost;
                                }
                            ],
                            [
                                'attribute' => 'period',
                                'value' => 'period',
                                'filter' => false,
                            ],

                            [
                                'label' => 'OM',
                                'value' => 'channel.om0.username',
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