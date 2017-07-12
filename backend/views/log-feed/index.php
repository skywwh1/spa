<?php

use kartik\grid\GridView;
use kartik\export\ExportMenu;
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

                    <?php // echo $this->render('_search', ['model' => $searchModel]);
                    $columns = [
                        ['class' => 'yii\grid\SerialColumn'],

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
                        [
                            'attribute' => 'feed_time',
                            'value' => function ($model) {
                                return gmdate('Y-m-d H:i',$model->feed_time + 8*3600);
                            },
                            'filter' => false,
                        ],
                        [
                            'attribute' => 'click_time',
                            'value' => function ($model) {
                                return gmdate('Y-m-d H:i',$model->click_time + 8*3600);
                            },
                            'filter' => false,
                        ],
                        'om',
                        'bd',
                        'pm',
//             'is_post',
//             'create_time:datetime',

                    ];
                    $fullExportMenu = ExportMenu::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => $columns,
                        'target' => ExportMenu::TARGET_BLANK,
                        'fontAwesome' => true,
                        'showConfirmAlert' => false,
                        'batchSize' => 20,
                        'pjaxContainerId' => 'kv-pjax-container',
                        'dropdownOptions' => [
                            'label' => 'Export All',
                            'class' => 'btn btn-default'
                        ],
                        'exportConfig' => [
                            ExportMenu::FORMAT_TEXT => false,
                            ExportMenu::FORMAT_PDF => false,
                            ExportMenu::FORMAT_EXCEL_X => false,
                            ExportMenu::FORMAT_HTML => false,
                        ],
                    ]);
                    ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => $columns,
                        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
                        'layout' => '{toolbar}{summary} {items} {pager}',
                        'toolbar' => [
                            $fullExportMenu,
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>