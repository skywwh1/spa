<?php

use common\models\Category;
use common\models\RegionsDomain;
use common\models\TrafficSource;
use yii\bootstrap\Button;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
use common\models\PriceModel;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\AllCampaignSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'All Offer List';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div id="nav-menu" data-menu="alloffers"></div>
    <div class="campaign-channel-log-index">

        <h3><?= Html::encode($this->title) ?></h3>


        <?php Modal::begin([
            'id' => 'campaign-detail-modal',
            'size' => 'modal-lg',
        ]);

        echo '<div id="campaign-detail-content"></div>';

        Modal::end(); ?>
        <?php Pjax::begin(['id' => 'countries']); ?>
        <?= GridView::widget(['dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'columns' => ['id',
                //            'campaign.id',
                'campaign_name',
                //            'tag',
                // 'campaign_uuid',
                //            'pricing_mode',
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
                //            'indirect',
                //            [
                //                'attribute' => 'indirect',
                //                'value' => function ($data) {
                //                    return ModelsUtil::getStatus($data->indirect);
                //                }
                //            ],
                'category',
                [
                    'attribute' => 'target_geo',
                    'value' => 'geo',
                ],
//            'target_geo',
                //            'target_geo',
                //             'promote_start',
                // 'promote_end',
                // 'end_time:datetime',
                //'device',
                //            [
                //                'attribute' => 'device',
                //                'value' => function ($data) {
                //                    return ModelsUtil::getDevice($data->device);
                //                },
                //            ],
                //            'platform',
                [
                    'attribute' => 'platform',
//                    'value' => 'platform',
//                    'value' => function ($data) {
//                        return ModelsUtil::getPlatformNew($data->platform);
//                    },
//                    'filter' => ModelsUtil::platform,
                    'filter' => \common\models\Platform::find()
                        ->select(['name', 'value'])
                        ->orderBy('id')
                        ->indexBy('value')
                        ->column()
                ],
                // 'budget',
                // 'open_budget',
                // 'daily_cap',
                // 'open_cap',
                //            'adv_price',
                //'now_payout',
                [
                    'attribute' => 'now_payout',
                    'filter' => false,
                ],

//                         'traffic_source',
                [
                    'attribute' => 'traffic_source',
                    'filter' => TrafficSource::find()
                        ->select(['name', 'value'])
                        ->orderBy('id')
                        ->indexBy('value')
                        ->column()
                ],
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
//            [
//                'attribute' => 'status',
//                'value' => function ($data) {
//                    return isset($data->status) ? $data->status : "";
//                },
//            ],

                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{view}',
                    'header' => 'More info',
                    'buttons' => [
                        'view' => function ($url, $model) {
                            $url = Url::to(['camp-log/campaign-view', 'id' => $model->id,]);
                            return Html::button('view', ['class' => 'btn btn-primary btn-xs', 'value' => $url, 'data-view' => 0]);
                        },
                    ],
                ],
                [
                    'class' => 'yii\grid\ActionColumn',
                    'template' => '{apply}',
                    'header' => 'Apply',
                    'buttons' => [
                        'apply' => function ($url, $model) {
                            if ($model->isApply($model->id, Yii::$app->user->id)) {
                                $class = 'btn btn-primary btn-xs';
                                $title = Yii::t('yii', 'Applying');
                                switch ($model->apply_status) {
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


//                        return Html::button('apply',['class'=>'btn btn-primary btn-xs']);
                        }
                    ],
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
<?php
$this->registerJsFile(
    '@web/dist/js/dropdown.js',
    ['depends' => [yii\bootstrap\BootstrapAsset::className()]]
);
?>