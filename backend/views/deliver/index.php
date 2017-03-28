<?php

use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Html;

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
                <?= GridView::widget([
                    'id' => 'applying_list',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'pjax' => true, // pjax is set to always true for this demo
                    'responsive' => true,
                    'hover' => true,
                    'columns' => [
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'template' => '{all}',
                            'header' => 'Action',
                            'buttons' => [
                                'all' => function ($url, $model, $key) {
                                    return '<div class="dropdown">
                                      <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Actions
                                      <span class="caret"></span></button>
                                      <ul class="dropdown-menu">

                                      <li><a data-view="0" data-url="/deliver/view?channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">View</a></li>
                                      <li><a data-view="0" data-url="/campaign-sts-update/pause?type=2&channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">Paused</a></li>
                                      <li><a data-view="0" data-url="/campaign-sts-update/update-cap?type=2&channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">Update Cap</a></li>
                                      <li><a data-view="0" data-url="/campaign-sts-update/update-discount?type=2&channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">Update Discount</a></li>
                                      <li><a data-view="0" data-url="/campaign-sts-update/update-payout?type=2&channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">Update Payout</a></li>
                                      <li><a data-view="0" data-url="/redirect-log/create?type=2&channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">Redirect</a></li>
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
                        [
                            'attribute' => 'channel_id',
                            'value' => 'channel.username',
                            'label' => 'Channel'
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
                        'create_time:datetime',
                        // 'update_time:datetime',
                        // 'track_url:url',
                        // 'note',
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
