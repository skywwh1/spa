<?php

use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\LogPostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'installs log';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="log-post-index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
                <div class="log-post-index">

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
                            [
                                'attribute' => 'advertiser_name',
//                                'value' => function($model){
//                                  return $model->advertiser_name;
//                                },
                                'label' => 'Advertiser',
//                                'pageSummary' => true,
                            ],
                            'click_uuid',
                            'click_id',
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
                            [
                                'attribute' => 'channel_id',
                                'value' => 'channel.username',
                                'label' => 'Channel'
                            ],
                            'post_time:datetime',

                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>