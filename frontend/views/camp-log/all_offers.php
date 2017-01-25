<?php

use common\models\Category;
use common\models\RegionsDomain;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CampaignSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'All Offer List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="alloffers"></div>
<div class="campaign-channel-log-index">

    <h3><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?php Pjax::begin(); ?>    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'id',
//            'campaign.id',
            'campaign_name',
//            'tag',
           // 'campaign_uuid',
//            'pricing_mode',
            [
                'attribute' => 'pricing_mode',
                'value' => function ($data) {
                    return ModelsUtil::getPricingMode($data->pricing_mode);
                }
            ],
//            'indirect',
//            [
//                'attribute' => 'indirect',
//                'value' => function ($data) {
//                    return ModelsUtil::getStatus($data->indirect);
//                }
//            ],
//            'category',
            [
                'attribute' => 'category',
                'value' => function ($data) {
                    return Category::findOne(['id' => $data->category])->name;
                }
            ],
            [
                'attribute' => 'target_geo',
                'value' => function ($data) {
                    return RegionsDomain::findOne(['id' => $data->target_geo])->domain;
                }
            ],
//            'target_geo',
//             'promote_start',
            // 'promote_end',
            // 'end_time:datetime',
            //'device',
            [
                'attribute' => 'device',
                'value' => function ($data) {
                    return ModelsUtil::getDevice($data->device);
                },
            ],
//            'platform',
            [
                'attribute' => 'platform',
                'value' => function ($data) {
                    return ModelsUtil::getPlatform($data->platform);
                },
            ],
            // 'budget',
            // 'open_budget',
            // 'daily_cap',
            // 'open_cap',
//            'adv_price',
             'now_payout',

            // 'traffice_source',
            // 'note',
            // 'preview_link',
            // 'icon',
            // 'package_name',
            // 'app_name',
            // 'app_size',

            // 'version',
            // 'app_rate',
            // 'description',
            // 'creative_link',
            // 'creative_type',
            // 'creative_description',
            // 'carriers',
            // 'conversion_flow',
            // 'recommended',

//            'cap',
//            'cvr',
//            'epc',
//             'pm',
//             'bd',
//            'status',
            [
                'attribute' => 'status',
                'value' => function ($data) {
                    return isset($data->status) ? $data->status : "";
                },
            ],

//            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    <?php Pjax::end(); ?></div>
