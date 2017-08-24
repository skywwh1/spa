<?php

use kartik\grid\GridView;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Anti Cheat CVR';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="deliver_index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info ">
            <div class="box-body">
                <p>&nbsp;&nbsp; &nbsp;The CVR for the following channels are high, here’re actions made:</p>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
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
                                      <li><a data-view="0" data-url="/campaign-sts-update/pause?type=2&channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">Paused</a></li>
                                      <li><a data-view="0" data-url="/campaign-sts-update/update-discount?type=2&channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">Update Discount</a></li>
                                      <li><a data-view="0" data-url="/redirect-log/create?type=2&channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">Redirect</a></li>
                                      <li><a data-view="0" data-url="/redirect-log/detail?type=2&channel_id=' . $model->channel_id . '&campaign_id=' . $model->campaign_id . '">View Redirect</a></li>
                                      </ul>
                                    </div>';
                                },
                            ],
                        ],
                        'campaign_id',
                        'campaign.advertiser0.username',
                        'campaign.campaign_name',
                        'channel.username',
                        'match_install',
                        'match_cvr',
                        'action',
                        'pm',
                        'bd',
                        'om'
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