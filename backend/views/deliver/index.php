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

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                      //  ['class' => 'yii\grid\SerialColumn'],
                        [
                                'attribute'=>'campaign.campaign_name',
                                'filter'=>true
                        ],
//                        'campaign.campaign_name',
                        'channel.username',
                        'pricing_mode',
                        'pay_out',
                        'daily_cap',
                         'discount',
                        // 'is_run',
                        // 'creator',
                         'create_time:datetime',
                        // 'update_time:datetime',
                        // 'track_url:url',
                        // 'note',

                        [
                            'class' => 'yii\grid\ActionColumn',
                            'template' => '{all}',
                            'header'=>'Action',
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
                                                    'url' => ['view', 'channel_id' => $model->channel_id,'campaign_id'=>$model->campaign_id],
                                                ],
                                                [
                                                    'label' => \Yii::t('yii', 'Paused'),
                                                    'url' => ['#'],
                                                    'visible' => true,  // if you want to hide an item based on a condition, use this
                                                    'linkOptions'=>['data-view'=>0,'data-url'=>'/deliver/pause?channel_id='.$model->channel_id.'&campaign_id='.$model->campaign_id],
                                                ],
                                                [
                                                    'label' => \Yii::t('yii', 'Daily Cap'),
                                                    'url' => ['daily_cap',  'channel_id' => $model->channel_id,'campaign_id'=>$model->campaign_id],
                                                    'visible' => true,  // if you want to hide an item based on a condition, use this
                                                ],
                                                [
                                                    'label' => \Yii::t('yii', 'Discount'),
                                                    'url' => ['discount',  'channel_id' => $model->channel_id,'campaign_id'=>$model->campaign_id],
                                                    'visible' => true,  // if you want to hide an item based on a condition, use this
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

            </div>
        </div>
    </div>
</div>
<?php
$this->registerJsFile(
    '@web/admin/js/dropdown.js',
    ['depends' => [yii\bootstrap\BootstrapAsset::className()]]
);
$this->registerJs(<<<JS
$(document).on("click", "a[data-view=0]", function (e) {
     //alert('aaa');
     //console.log($(this));
    $('#campaign-detail-modal').modal('show').find('#campaign-detail-content').load($(this).attr('data-url'));
    //$.pjax.reload({container:"#countries"});  //Reload GridView

});
JS
);
?>
<?php Modal::begin([
    'id' => 'campaign-detail-modal',
    'size' => 'modal-md',
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false,
    ],
]);

echo '<div id="campaign-detail-content"></div>';

Modal::end(); ?>
