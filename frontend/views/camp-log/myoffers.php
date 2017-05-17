<?php

use common\models\Platform;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\PriceModel;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CampaignChannelLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Approved Offers';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="myoffers"></div>
<div class="campaign-channel-log-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
//        'showHeader'=>false,
        'columns' => [
            'campaign_id',
//            'campaign.campaign_name',
            [
                'label' => 'Campaign Name',
                'attribute' => 'campaign_name',
                'value' => 'campaign.campaign_name',
                'filter' => true,
            ],
//            'adv_price',
            //'pricing_mode',
//            [
//                'attribute' => 'pricing_mode',
//                'value' => function ($data) {
//                    return ModelsUtil::getPricingMode($data->pricing_mode);
//                },
//                'filter' => ModelsUtil::pricing_mode,
//            ],
            [
                'attribute' => 'pricing_mode',
                'value' => function ($data) {
                    return ModelsUtil::getPricingModeNew($data->pricing_mode);
                },
                'filter' =>  PriceModel::find()
                    ->select(['name', 'value'])
                    ->orderBy('id')
                    ->indexBy('value')
                    ->column(),
            ],
            [
                'attribute' => 'pay_out',
//                'filter' => false,
            ],
//            'daily_cap',
            [
                'attribute' => 'daily_cap',
//                'filter' => false,
            ],
            [
                'label' => 'GEO',
                'attribute' => 'geo',
                'value' => 'campaign.geo',
                'filter' => true,
            ],
            [
                'label' => 'Platform',
                'attribute' => 'platform',
                'value' => 'campaign.platform',
                'filter' => \common\models\Platform::find()
                    ->select(['name', 'value'])
                    ->orderBy('id')
                    ->indexBy('value')
                    ->column()
            ],
//             'actual_discount',
//             'discount',
            //'is_run',
//            [
//                'label' => 'Running',
//                'attribute' => 'is_run',
//                'value' => function ($data) {
//                    return ModelsUtil::getStatus($data->is_run);
//                },
//                'filter' => ModelsUtil::status,
//            ],
//             'creator',
//             'create_time:datetime',
//             'update_time:datetime',
//             'track_url:url',
//            'click',
//            [
//                'attribute' => 'click',
//                'filter' => false,
//            ],
////            'unique_click',
//            [
//                'attribute' => 'unique_click',
//                'filter' => false,
//            ],
////            'install',
//            [
//                'attribute' => 'install',
//                'filter' => false,
//            ],
//             'cvr',
//             'cost',
//             'match_install',
//             'match_cvr',
//             'revenue',
//             'def',
//             'deduction_percent',
//             'profit',
//             'margin',
//             'note',
            [
                'class' => 'yii\grid\ActionColumn', 'template' => '{view}',
                'header' => 'Detail',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>
