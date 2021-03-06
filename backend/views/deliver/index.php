<?php

use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel common\models\DeliverSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'S2S Log';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="deliver_index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info ">
            <div class="box-body">

                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                <?php
                $columns = [
                    'campaign_id',
                    [
                        'attribute' => 'campaign_name',
                        'value' => function ($data) {
                            if (isset($data->campaign)) {
                                return  $data->campaign->campaign_name;
                            }
                        },
                        'label' => 'Campaign',
                    ],
                    'campaign_uuid',
                    'channel_id',
                    [
                        'attribute' => 'channel_name',
                        'value' => 'channel.username',
                        'label' => 'Channel'
                    ],
                    'pricing_mode',
                    'pay_out',
                    'daily_cap',
                    'discount',
                    'end_time:datetime',
                    [
                        'attribute' => 'status',
                        'value' => function ($model) {
                            return ModelsUtil::getCampaignStatus($model->status);
                        },
                        'filter' => ModelsUtil::campaign_status
                    ],
                    [
                        'attribute' => 'is_redirect',
                        'value' => function ($model) {
                            return ModelsUtil::getStatus($model->is_redirect);
                        },
                        'filter' => ModelsUtil::status,
                    ],
                    'create_time:datetime',
                    'redirect_time:datetime',
                    'om',
                    'bd',
                    'pm',
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
                    'id' => 'applying_list',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'pjax' => true, // pjax is set to always true for this demo
                    'responsive' => true,
                    'hover' => true,
                    'pjaxSettings' => ['options' => ['id' => 'kv-unique-id-report']],
                    'layout' => '{toolbar}{summary} {items} {pager}',
                    'toolbar' => [
                        $fullExportMenu,
                    ],
                    'columns' => [
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'template' => '{all}',
                            'header' => 'Action',
                            'buttons' => [
                                'all' => function ($url, $model, $key) {
                                    $restart = '';
                                    if($model->campaign->status == 1 && $model->status == 2){
                                        $restart = '<li><a data-view="0" data-url="/campaign-sts-update/sts-restart?type=2&channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">Restart</a></li>';
                                    }
                                    return '<div class="dropdown">
                                      <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Actions
                                      <span class="caret"></span></button>
                                      <ul class="dropdown-menu">

                                      <li><a data-view="0" data-url="/deliver/view?channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">View</a></li>
                                      <li><a data-view="0" data-url="/campaign-sts-update/pause?type=2&channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">Paused</a></li>'.$restart.'
                                      <li><a data-view="0" data-url="/campaign-sts-update/sub-pause?type=2&channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">Sub Paused</a></li>
                                      <li><a data-view="0" data-url="/campaign-sts-update/update-cap?type=2&channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">Update Cap</a></li>
                                      <li><a data-view="0" data-url="/campaign-sts-update/update-discount?type=2&channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">Update Discount</a></li>
                                      <li><a data-view="0" data-url="/campaign-sts-update/update-payout?type=2&channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">Update Payout</a></li>
                                      <li><a data-view="0" data-url="/redirect-log/create?type=2&channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">Redirect</a></li>
                                      <li><a data-view="0" data-url="/campaign-sub-channel-log-redirect/create?channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">Sub Redirect</a></li>
                                      <li><a data-view="0" data-url="/deliver/send-email?channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">Send Email</a></li>
                                      </ul>
                                    </div>';
                                },
                            ],
                        ],
                        //  ['class' => 'yii\grid\SerialColumn'],
                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'campaign_name',
                            'value' => function ($data) {
                                if (isset($data->campaign)) {
                                    return Html::tag('div', $data->campaign->name, ['data-toggle' => 'tooltip', 'data-placement' => 'left', 'title' => $data->campaign->campaign_name, 'style' => 'cursor:default;']);
                                }
                            },
                            'width' => '60px',
                            'format' => 'raw',
                            'label' => 'Campaign',
                        ],
                        'campaign_id',
                        'campaign_uuid',
                        'channel_id',
                        [
                            'attribute' => 'channel_name',
                            'value' => 'channel.username',
                            'label' => 'Channel'
                        ],
                        [
                            'attribute' => 'adv_name',
                            'label' => 'Advertiser',
                            'value' => function ($model) {
                                return $model->campaign->advertiser0->username;
                            },
                            'filter' => true,
                        ],
                        'pricing_mode',
                        'pay_out',
                        'daily_cap',
                        'discount',
                        'end_time:datetime',
                        // 'is_run',
                        // 'creator',
                        [
                            'attribute' => 'status',
                            'value' => function ($model) {
                                return ModelsUtil::getCampaignStatus($model->status);
                            },
                            'filter' => ModelsUtil::campaign_status
                        ],
                        [
                            'attribute' => 'is_redirect',
                            'value' => function ($model) {
                                return ModelsUtil::getStatus($model->is_redirect);
                            },
                            'filter' => ModelsUtil::status,
                        ],
                        'create_time:datetime',
                        // 'update_time:datetime',
                        // 'track_url:url',
                        // 'note',
                        'redirect_time:datetime',
                        'om',
                        'bd',
                        'pm',
//                        [
//                            'label' => 'OM',
//                            'value' => function($model){
//                                return $model->channel->om0->username;
//                            }
//                        ],
//                        [
//                            'label' => 'BD',
//                            'value' => function($model){
//                                return $model->campaign->advertiser0->bd0->username;
//                            }
//                        ],
//                        [
//                            'label' => 'PM',
//                            'value' => function($model){
//                                return empty($model->campaign->advertiser0->pm0)?"":$model->campaign->advertiser0->pm0->username;
//                            }
//                        ],
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
<?php Modal::begin([
    'id' => 'deliver-modal',
    'size' => 'modal-md',
//    'header' =>'00',
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false,
    ],
]);

echo '<div id="deliver-detail-content"></div>';

Modal::end(); ?>
