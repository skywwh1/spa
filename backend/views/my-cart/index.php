<?php
use common\models\TrafficSource;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel common\models\MyCartSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Carts';
$this->params['breadcrumbs'][] = $this->title;

?>
<div id="nav-menu" data-menu="my-cart-index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
                <div class="my-cart-index">

                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
                <p>
                    <button type="button" id = 'selectButton' class="btn btn-primary">Select</button>
                    <button type="button" id = 'deleteButton' class="btn btn-primary">Delete</button>
                </p>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'id' => 'grid',
                    'layout' => '{toolbar}{summary} {items} {pager}',
                    'toolbar' =>['{toggleData}',] ,
                    'toggleDataOptions' => [
                        '$type' => '$options',
                    ],
            'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'class' => 'yii\grid\CheckboxColumn',
                'header' => Html::checkBox('selection_all', false, [
                    'class' => 'select-on-check-all',
                    'label' => 'Select',
                ]),
            ],
                [
                // 'label' => 'id',
                 'attribute' => 'id',
                 'value' => 'id',
            ],
            [
                // 'label' => 'campaign_id',
                 'attribute' => 'campaign_id',
                 'value' => 'campaign_id',
            ],
//            [
//                // 'label' => 'campaign_name',
//                 'attribute' => 'campaign_name',
//                 'value' => 'campaign_name',
//            ],
//            [
//                // 'label' => 'target_geo',
//                 'attribute' => 'target_geo',
//                 'value' => 'target_geo',
//            ],
            [
                'class' => '\kartik\grid\DataColumn',
                'attribute' => 'campaign_name',
                'value' => function ($data) {
                    return Html::tag('div', $data->campaign_name, ['data-toggle' => 'tooltip', 'data-placement' => 'left', 'title' => $data->campaign_name, 'data-delay' => '{"show":0, "hide":3000}', 'style' => 'cursor:default;']);
                },
                'width' => '60px',
                'format' => 'raw',
            ],
            [
                'class' => '\kartik\grid\DataColumn',
                'attribute' => 'target_geo',
                'value' => function ($data) {
                    return Html::tag('div', $data->target_geo, ['data-toggle' => 'tooltip', 'data-placement' => 'left', 'title' => $data->target_geo, 'data-delay' => '{"show":0, "hide":5000}', 'style' => 'cursor:default;']);
                },
                'width' => '60px',
                'format' => 'raw',
            ],
            [
                // 'label' => 'platform',
                 'attribute' => 'platform',
                 'value' => 'platform',
            ],
            [
                 'label' => 'payout',
                 'attribute' => 'payout',
                 'value' => 'payout',
            ],
            [
                 'label' => 'daily_cap',
                 'attribute' => 'daily_cap',
                 'value' => 'daily_cap',
            ],
//            [
//                 'label' => 'traffic_source',
//                 'attribute' => 'traffic_source',
//                 'value' => 'traffic_source',
//            ],
            [
                'attribute' => 'traffic_source',
                'value' => 'traffic_source',
                'filter' => TrafficSource::find()
                    ->select(['name', 'value'])
                    ->orderBy('id')
                    ->indexBy('value')
                    ->column(),
            ],
            [
                'attribute' => 'tag',
                'value' => function ($model) {
                    return ModelsUtil::getCampaignTag($model->tag);
                },
                'filter' => ModelsUtil::campaign_tag,
                'contentOptions' => function ($model) {
                    if ($model->tag == 3) {
                        return ['class' => 'bg-danger'];
                    } else if ($model->tag == 2) {
                        return ['class' => 'bg-warning'];

                    } else if ($model->tag == 4) {
                        return ['class' => 'bg-info'];
                    } else {
                        return ['class' => 'bg-success'];
                    }
                }
            ],
            [
                'attribute' => 'direct',
                'value' => function ($model) {
                    return ModelsUtil::getCampaignDirect($model->direct);
                },
                'filter' => ModelsUtil::campaign_direct,
            ],
            [
                 'label' => 'advertiser',
                 'attribute' => 'advertiser',
                 'value' => function($model){
                     return $model->advertiser0->username;
                 }
            ],

//        [
//        'class' => 'yii\grid\ActionColumn',
//        'header' => 'Action',
//        'template' => '{view}',
//        ],
        ],
        ]); ?>
        </div>
</div>
</div>
</div>
    <?php Modal::begin([
        'id' => 'my-cart-modal',
        'size' => 'modal-lg',
//    'header' =>'00',
        'clientOptions' => [
            'backdrop' => 'static',
            'keyboard' => false,
        ],
    ]);
    echo '<div id="my-cart-content"></div>';
    Modal::end(); ?>
<?php
$this->registerJsFile(
    '@web/js/select-good-campaign.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>
