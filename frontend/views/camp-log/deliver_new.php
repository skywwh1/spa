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

                <?= GridView::widget([
                    'id' => 'applying_list',
                    'dataProvider' => $dataProvider,
                    'pjax' => true, // pjax is set to always true for this demo
                    'responsive' => true,
                    'hover' => true,
                    'columns' => [
                        'campaign_id',
                        'campaign.campaign_name',
                        'campaign.platform',
                        'campaign.target_geo',
                        'pay_out',
                        [
                            'attribute'=>  'campaign.preview_link',
                            'value' => function ($model) {
                                if (empty($model->campaign->preview_link)){
                                    return "";
                                }else{
                                    return Html::a($model->campaign->preview_link,$model->campaign->preview_link, ['target' => '_blank']);
                                }
                            },
                            'format' => 'raw',
                        ],
                        [
                            'attribute'=>  'track_url',
                            'value' => function ($model) {
                                if (empty($model->track_url)){
                                    return "";
                                }else{
                                    return \yii\helpers\Url::to('@track' . $model->track_url);
                                }
                            },
                            'format' => 'raw',
                        ],
                        'campaign.traffic_source',
                        'daily_cap',
                        'kpi',
                        'note',
                        'campaign.carriers',
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
