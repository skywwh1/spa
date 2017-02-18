<?php

use common\models\RegionsDomain;
use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CampaignSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Campaign List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div id="nav-menu" data-menu="campaign_index"></div>
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body table-responsive">

                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
                    'headerRowOptions' => ['class' => 'kartik-sheet-style'],
                    'filterRowOptions' => ['class' => 'kartik-sheet-style'],
                    'pjax' => true, // pjax is set to always true for this demo
                    // set your toolbar
                    'toolbar' => [
                        ['content' =>
                            Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type' => 'button', 'title' => 'Add Book', 'class' => 'btn btn-success', 'onclick' => 'alert("This will launch the book creation form.\n\nDisabled for this demo!");']) . ' ' .
                            Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['grid-demo'], ['data-pjax' => 0, 'class' => 'btn btn-default', 'title' => 'Reset Grid'])
                        ],
                        '{export}',
                        '{toggleData}',
                    ],
                    // set export properties
                    'export' => [
                        'fontAwesome' => true
                    ],
                    // parameters from the demo form
                    'bordered' => true,
                    'striped' => true ,
                    'condensed' => true,
                    'responsive' => true,
                    'hover' => true,
                    'resizableColumns'=>true,
                    'resizeStorageKey'=>Yii::$app->user->id . '-' . date("m"),
                    'showPageSummary' => true,
//                    'exportConfig' => $exportConfig,
                    'columns' => [
                        'id',
                        [
                            'attribute' => 'advertiser',
                            'value' => 'advertiser0.username',
                        ],

//                        'campaign_name',
                        [
                            'attribute' => 'campaign_name',
                            'value' => 'campaign_name',
//                            'contentOptions'=>['style'=>'max-width: 100px;'] // <-- right here
                        ],
                        'campaign_uuid',
//                        //'tag',
//                        [
//                            'attribute' => 'tag',
//                            'value' => function ($data) {
//                                return ModelsUtil::getCampaignTag($data->tag);
//                            },
//                            'filter' => ModelsUtil::campaign_tag,
//                        ],
                        'pricing_mode',
//                        [
//                            'attribute' => 'pricing_mode',
//                            'value' => function ($data) {
//                                return ModelsUtil::getPricingMode($data->pricing_mode);
//                            },
//                            'filter' => ModelsUtil::pricing_mode,
//                        ],
//                        'indirect',
                        'category',
                        'target_geo',
//                        [
//                            'attribute' => 'target_geo',
//                            'value' => function ($data) {
//                                return RegionsDomain::findOne(['id' => $data->target_geo])->domain;
//                            }
//                        ],
//             'promote_start',
                        // 'promote_end',
                        // 'end_time:datetime',
//                    'device',
                        'platform',
//                        [
//                            'attribute' => 'platform',
//                            'value' => function ($data) {
//                                return ModelsUtil::getPlatform($data->platform);
//                            },
//                            'filter' => ModelsUtil::platform,
//                        ],
                        // 'budget',
                        // 'open_budget',
                        // 'daily_cap',
                        // 'open_cap',
                        'adv_price',
                        // 'now_payout',

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

                        'cap',
                        'cvr',
                        'epc',
//             'pm',
//             'bd',
                        //'status',
                        [
                            'attribute' => 'status',
                            'value' => function ($model) {
                                return ModelsUtil::getCampaignStatus($model->status);
                            },
                            'filter' => ModelsUtil::campaign_status,
                        ],

                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'template' => '{view} {update}',
                            'header' => 'Action',
                        ],
                    ],


                ]); ?>
            </div>
        </div>
    </div>
</div>