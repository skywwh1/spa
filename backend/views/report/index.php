<?php

use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Campaign report';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="report-index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body">
                <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'containerOptions' => ['style' => 'overflow: auto'],
                    'pjax' => true, // pjax is set to always true for this demo
                    'responsive' => true,
                    'hover' => true,
                    'showPageSummary' => true,
                    'layout' => '{toolbar}{summary} {items} {pager}',
                    'toolbar' => [
                        '{toggleData}',
                        '{export}',
                    ],
                    'export' => [
                        'fontAwesome' => true,
                        'showConfirmAlert' => false,
                        'target' => GridView::TARGET_BLANK
                    ],
                    'columns' => [
//                    ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'campaign_id',
                            'pageSummary' => 'Total'
                        ],
                        [
                            'attribute' => 'campaign_id',
                            'value' => 'campaign.name',
                            'label' => 'Campaign Name',
                        ],
//                    'campaign.campaign_name',
                        'campaign_uuid',
                        'channel_id',
                        [
                            'attribute' => 'channel_id',
                            'value' => 'channel.username',
                            'label' => 'Channel Name',
                        ],
                        [
                            'attribute' => 'click',
                            'pageSummary' => true,
                        ],

                        [
                            'attribute' => 'unique_click',
                            'pageSummary' => true,
                        ],

                        [
                            'attribute' => 'install',
                            'pageSummary' => true,
                        ],
                        'cvr',
                        'campaign.avg_price',
                        'cost',
                        [
                            'attribute' =>  'match_install',
                            'pageSummary' => true,
                        ],

                        'match_cvr',
                        'campaign.adv_price',
                        'revenue',
                        'def',
                        'deduction_percent',
                        'profit',
                        'margin',
//            'pricing_mode',
//            'pay_out',
//            'daily_cap',
                        // 'actual_discount',
//                        'note',

                        //['class' => 'yii\grid\ActionColumn'],
                        // 'track_url:url',
                        // 'update_time:datetime',
                        // 'create_time:datetime',
                        // 'creator',
                        // 'is_run',
//                        'discount',
                        [
                            'attribute' => 'discount',
                            'filter' => false
                        ],
                        [
                            'attribute' => 'deduction_percent',
                            'value' => function ($model) {
                                if ($model->match_install !== 0) {
                                    return ($model->def / $model->match_install);
                                } else {
                                    return 0;
                                }
                            },
                            'filter' => false
                        ],
                    ],
                ]); ?>

            </div>
        </div>
    </div>
</div>
