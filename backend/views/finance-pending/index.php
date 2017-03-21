<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\FinancePendingSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Finance Pendings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="finance-pending-index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
                <div class="finance-pending-index">

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <p>
                        <?= Html::a('Add Campaign Pending', ['add-campaign'], ['class' => 'btn btn-success']) ?>
                        <?= Html::a('Add ADV Pending', ['add-adv'], ['class' => 'btn btn-success']) ?>
                    </p>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [

                            [
                                // 'label' => 'id',
                                'attribute' => 'id',
                                'value' => 'id',
                            ],
                            [
                                 'label' => 'Channel',
                                'attribute' => 'channel_name',
                                'value' => 'channel.username',
                            ],
                            [
                                // 'label' => 'campaign_id',
                                'attribute' => 'campaign_id',
                                'value' => 'campaign_id',
                            ],
                            [
                                 'label' => 'Campaign',
                                'attribute' => 'campaign_name',
                                'value' => 'campaign.name',
                            ],
                            [
                                // 'label' => 'start_date',
                                'attribute' => 'start_date',
                                'value' => 'start_date',
                                'format'=>'date',
                            ],
                            [
                                // 'label' => 'end_date',
                                'attribute' => 'end_date',
                                'value' => 'end_date',
                                'format'=>'date',

                            ],
                            [
                                'label' => 'installs',
                                'attribute' => 'installs',
                                'value' => 'installs',
                            ],
                            [
                                'label' => 'cost',
                                'attribute' => 'cost',
                                'value' => 'cost',
                            ],
                            [
                                'label' => 'revenue',
                                'attribute' => 'revenue',
                                'value' => 'revenue',
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
                                'label' => 'bd',
                                'attribute' => 'bd',
                                'value' => 'bd',
                            ],
                            [
                                'label' => 'om',
                                'attribute' => 'om',
                                'value' => 'om',
                            ],
                            [
                                'label' => 'status',
                                'attribute' => 'status',
                                'value' => function ($model) {
                                    return ModelsUtil::getPendingStatus($model->status);
                                }
                            ],
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
                                'template' => '{view}{update}',
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>