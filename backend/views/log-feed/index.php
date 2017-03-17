<?php

use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\LogFeedSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Match install';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="log-feed-index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
                <div class="log-feed-index">

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'showPageSummary' => true,
                        'layout' => '{toolbar}{summary} {items} {pager}',
                        'toolbar' => [
                            '{toggleData}',
                           // '{export}',
                        ],
                        'columns' => [
                           // ['class' => 'yii\grid\SerialColumn'],

//                    'id',
//            'auth_token',

                            [
                                'attribute' => 'click_uuid',
                                'pageSummary' => 'Total'
                            ],
//            'click_id',
                            [
                                'attribute' => 'advertiser_name',
//                                'value' => function($model){
//                                  return $model->advertiser_name;
//                                },
                                'label' => 'Advertiser',
//                                'pageSummary' => true,
                            ],
                            [
                                'attribute' => 'campaign_name',
                                'value' => 'campaign_name',
                                'label' => 'Campaign',
//                                'pageSummary' => true,
                            ],
                            [
                                'attribute' => 'campaign_id',
                                'value' => 'campaign_id',
                                'label' => 'campaign_id',
//                                'pageSummary' => true,
                            ],
                            [
                                'attribute' => 'campaign_uuid',
                                'value' => 'campaign.campaign_uuid',
                                'label' => 'Campaign uuid',
//                                'pageSummary' => true,
                            ],
//                        'campaign.campaign_name',
                            [
                                'attribute' => 'channel_id',
                                'value' => 'channel.username',
                                'label' => 'Channel'
                            ],
//                            'channel.username',
//                            'campaign.name',
//            'ch.username',
                            'ch_subid',
//             'all_parameters:ntext',
//             'ip',
//             'adv_price',
                            'feed_time:datetime',
//             'is_post',
//             'create_time:datetime',

                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>