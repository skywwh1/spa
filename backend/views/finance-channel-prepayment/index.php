<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FinanceChannelPrepaymentSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Finance Apply Prepayments';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="finance-apply-prepayment-index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
                <div class="finance-apply-prepayment-index">

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <p>
                        <?= Html::a('Create Finance Apply Prepayment', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            [
                                // 'label' => 'id',
                                'attribute' => 'id',
                                'value' => 'id',
                            ],
                            [
                                // 'label' => 'channel_bill_id',
                                'attribute' => 'channel_bill_id',
                                'value' => 'channel_bill_id',
                            ],
                            [
                                // 'label' => 'channel_id',
                                'attribute' => 'channel_id',
                                'value' => 'channel_id',
                            ],
                            [
                                // 'label' => 'timezone',
                                'attribute' => 'timezone',
                                'value' => 'timezone',
                            ],
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

                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'template' => '{view}{update}{delete}',
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>