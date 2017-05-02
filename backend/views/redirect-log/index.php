<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\RedirectLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Redirect Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="redirect-log-index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
                <div class="redirect-log-index">

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

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
                                // 'label' => 'campaign_id',
                                'attribute' => 'campaign_id',
                                'value' => 'campaign_id',
                            ],
                            [
                                'label' => 'Campaign',
                                'attribute' => 'campaignName',
                                'value' => 'campaign.campaign_name',
                                //'filter' => false,
                            ],
                            [
                                // 'label' => 'channel_id',
                                'attribute' => 'channel_id',
                                'value' => 'channel_id',
                            ],
                            [
                                'label' => 'Channel',
                                'attribute' => 'channelName',
                                'value' => 'channel.username',
                               // 'filter' => false,
                            ],
                            [
                                // 'label' => 'campaign_id_new',
                                'attribute' => 'campaign_id_new',
                                'value' => 'campaign_id_new',
                            ],
                            [
                                'label' => 'Redirect Campaign',
                                'attribute' => 'redirectCampaignName',
                                'value' => 'campaignIdNew.campaign_name',
                             //   'filter' => false,
                            ],
//            [
//                // 'label' => 'daily_cap',
//                 'attribute' => 'daily_cap',
//                 'value' => 'daily_cap',
//            ],
                            //[
                            // 'label' => 'actual_discount',
                            // 'attribute' => 'actual_discount',
                            // 'value' => 'actual_discount',
                            // ],
                            [
                                'label' => 'discount',
                                'attribute' => 'discount',
                                'value' => 'discount',
                                'filter' => false
                            ],
                            //[
                            // 'label' => 'discount_numerator',
                            // 'attribute' => 'discount_numerator',
                            // 'value' => 'discount_numerator',
                            // ],
                            //[
                            // 'label' => 'discount_denominator',
                            // 'attribute' => 'discount_denominator',
                            // 'value' => 'discount_denominator',
                            // ],
                            [
                                'label' => 'status',
                                'attribute' => 'status',
                                'value' => function ($model) {
                                    return ModelsUtil::getRedirectStatus($model->status);
                                },
                                'filter' => ModelsUtil::redirect_status
                            ],
                            [
                                'label' => 'create_time',
                                'attribute' => 'create_time',
                                'value' => 'create_time',
                                'format' => 'datetime',
                                'filter' => false
                            ],
                            [
                                'label' => 'end_time',
                                'attribute' => 'end_time',
                                'value' => 'end_time',
                                'format' => 'datetime',
                                'filter' => false
                            ],
                            //[
                            // 'label' => 'update_time',
                            // 'attribute' => 'update_time',
                            // 'value' => 'update_time:datetime',
                            // ],
                            //[
                            // 'label' => 'creator',
                            // 'attribute' => 'creator',
                            // 'value' => 'creator',
                            // ],

//        [
//        'class' => 'yii\grid\ActionColumn',
//        'header' => 'Action',
//        'template' => '{view}{update}',
//        ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>