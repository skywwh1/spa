<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CampaignSubChannelLogRedirectSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Campaign Sub Channel Log Redirects';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="campaign-sub-channel-log-redirect-index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
            <div class="campaign-sub-channel-log-redirect-index">
                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        [
                        'class' => 'yii\grid\ActionColumn',
                        'header' => 'Action',
                        'template' => '{delete}',
                        ],
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
                            // 'label' => 'channel_id',
                            'attribute' => 'sub_channel',
                            'value' => 'sub_channel',
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
                            'filter' => ModelsUtil::sub_redirect_status
                        ],
                        [
                            'attribute' => 'create_time',
                            'value' => function ($model) {
                                return gmdate('Y-m-d H:i',$model->create_time + 3600*8);
                            },
                            'filter' => false,
                        ],
                        [
                            'attribute' => 'end_time',
                            'value' => function ($model) {
                                return gmdate('Y-m-d H:i',$model->end_time + 3600*8);
                            },
                            'filter' => false,
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
                    ],
                ]); ?>
        </div>
</div>
</div>
</div>