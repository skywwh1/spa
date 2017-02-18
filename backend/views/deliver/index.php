<?php

use yii\bootstrap\ButtonDropdown;
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

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
            <div class="box-body table-responsive no-padding">

                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                <?php Pjax::begin(); ?>
                <?= GridView::widget([
                    'id' => 'applying_list',
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                        //  ['class' => 'yii\grid\SerialColumn'],
                        [
                            'attribute' => 'campaign_id',
                            'value' => 'campaign.campaign_name',
                            'label' => 'Campaign',
                        ],
//                        'campaign.campaign_name',
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

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{all}',
                            'header' => 'Action',
                            'buttons' => [
                                'all' => function ($url, $model, $key) {
                                    return ButtonDropdown::widget([
                                        'encodeLabel' => false, // if you're going to use html on the button label
                                        'label' => 'Actions',
                                        'dropdown' => [
                                            'encodeLabels' => false, // if you're going to use html on the items' labels
                                            'items' => [
                                                [
                                                    'label' => \Yii::t('yii', 'View'),
                                                    'url' => ['#'],
                                                    'linkOptions' => ['data-view' => 0, 'data-url' => '/deliver/view?channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id],
                                                ],
                                                [
                                                    'label' => \Yii::t('yii', 'Paused'),
                                                    'url' => ['#'],
                                                    //  'visible' => isset($model->end_time) ? false : true,  // if you want to hide an item based on a condition, use this
                                                    'linkOptions' => ['data-view' => 0, 'data-url' => '/campaign-sts-update/pause?type=2&channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id],
                                                ],
                                                [
                                                    'label' => \Yii::t('yii', 'Update Cap'),
                                                    'url' => ['#'],
                                                    'linkOptions' => ['data-view' => 0, 'data-url' => '/campaign-sts-update/update-cap?type=2&channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id],
                                                ],
                                                [
                                                    'label' => \Yii::t('yii', 'Update Discount'),
                                                    'url' => ['#'],
                                                    // 'visible' => true,  // if you want to hide an item based on a condition, use this
                                                    'linkOptions' => ['data-view' => 0, 'data-url' => '/campaign-sts-update/update-discount?type=2&channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id],
                                                ],
                                                [
                                                    'label' => \Yii::t('yii', 'Update Payout'),
                                                    'url' => ['#'],
                                                    // 'visible' => true,  // if you want to hide an item based on a condition, use this
                                                    'linkOptions' => ['data-view' => 0, 'data-url' => '/campaign-sts-update/update-payout?type=2&channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id],
                                                ],
//                                                [
//                                                    'label' => \Yii::t('yii', 'Delete'),
//                                                    'linkOptions' => [
//                                                        'data' => [
//                                                            'method' => 'post',
//                                                            'confirm' => \Yii::t('yii', 'Are you sure you want to delete this item?'),
//                                                        ],
//                                                    ],
//                                                    'url' => ['delete', 'id' => $key],
//                                                    'visible' => true,   // same as above
//                                                ],
                                            ],
                                            'options' => [
                                                'class' => 'dropdown-menu-right', // right dropdown
                                            ],
                                        ],
                                        'options' => [
                                            'class' => 'btn-primary dropup',   // btn-success, btn-info, et cetera
//                                            'aria-haspopup'=>true,
                                        ],
                                        // 'split' => true,    // if you want a split button
                                    ]);
                                },
                            ],
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerJsFile(
    '@web/admin/js/dropdown.js',
    ['depends' => [yii\bootstrap\BootstrapAsset::className()]]
);
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
