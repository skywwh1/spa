<?php

use common\models\Platform;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use common\models\PriceModel;
/* @var $this yii\web\View */
/* @var $searchModel frontend\models\CampaignChannelLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Recommend Offers';
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
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{apply}',
                'header' => 'Apply',
                'buttons' => [
                    'apply' => function ($url, $model) {
                        if ($model->campaign->isApply($model->campaign->id, Yii::$app->user->id)) {
                            $class = 'btn btn-primary btn-xs';
                            $title = Yii::t('yii', 'Applying');
                            switch ($model->campaign->apply_status) {
                                case 1:
                                    $class = 'btn btn-warning disabled btn-xs';
                                    $title = Yii::t('yii', 'Applying');
                                    break;
                                case 2:
                                    $class = 'btn btn-success disabled btn-xs';
                                    $title = Yii::t('yii', 'Approved');
                                    break;
                                case 3:
                                    $class = 'btn btn-danger disabled btn-xs';
                                    $title = Yii::t('yii', 'Reject');
                                    break;
                            }
                            return Html::a($title, '#', [
                                'class' => $class,
                                'title' => $title,
                            ]);
                        } else {
                            return Html::a('apply', $url, [
                                'class' => 'btn btn-primary btn-xs',
                                'title' => Yii::t('yii', 'Apply'),
                                'data-method' => 'post',
                                'data-pjax' => 'w0',

                            ]);
                        }
                    }
                ],
            ],
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
                'filter' => false,
            ],
            [
                'label' => 'Platform',
                'attribute' => 'platform',
                'value' => 'campaign.platform',
//                'filter' => \common\models\Platform::find()
//                    ->select(['name', 'value'])
//                    ->orderBy('id')
//                    ->indexBy('value')
//                    ->column()
                'filter' => false,
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
