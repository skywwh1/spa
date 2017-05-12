<?php

use common\models\Channel;
use common\models\TrafficSource;
use kartik\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $cams array */
/* @var $channel Channel */

$this->title = 'Recommend List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div id="nav-menu" data-menu="my_channels"></div>
    <div class="col-lg-12">
        <div class="box">
            <div class="box-body">
                <?= Html::button('Recommend to Channel ' . $channel->username, ['class' => 'btn btn-primary', 'id' => 'finish-recommend-channel-btn', 'data-url' => '/channel/send-recommend?id=' . $channel->id.'&cams='.$cams]) ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => false,
                    'id' => 'recommend-channel-grid',
                    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                    'layout' => '{summary} {items} {pager}',
                    'responsive' => true,
                    'hover' => true,
                    'columns' => [
                        'id',
                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'campaign_name',
                            'value' => function ($data) {
                                return Html::tag('div', $data->name, ['data-toggle' => 'tooltip', 'data-placement' => 'left', 'title' => $data->campaign_name, 'data-delay' => '{"show":0, "hide":3000}', 'style' => 'cursor:default;']);
                            },
                            'width' => '60px',
                            'format' => 'raw',
                        ],
                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'target_geo',
                            'value' => function ($data) {
                                return Html::tag('div', $data->geo, ['data-toggle' => 'tooltip', 'data-placement' => 'left', 'title' => $data->target_geo, 'data-delay' => '{"show":0, "hide":5000}', 'style' => 'cursor:default;']);
                            },
                            'width' => '60px',
                            'format' => 'raw',
                        ],
                        'platform',
                        'now_payout',
                        [
                            'attribute' => 'traffic_source',
                            'value' => 'traffic_source',
                            'filter' => TrafficSource::find()
                                ->select(['name', 'value'])
                                ->orderBy('id')
                                ->indexBy('value')
                                ->column(),
                        ],
                        'preview_link:url',
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerJsFile(
    '@web/js/campaign.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>

