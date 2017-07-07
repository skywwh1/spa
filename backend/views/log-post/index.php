<?php

use kartik\grid\GridView;
use kartik\export\ExportMenu;
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
                    <?php // echo $this->render('_search', ['model' => $searchModel]);
                    $columns = [
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
                        'layout' => '{toolbar}{summary} {items} {pager}',
                        'toolbar' => [
                            $fullExportMenu,
                        ],
                        'columns' => $columns,
                    ]); ?>
                </div>
            </div>
        </div>
    </div>