<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ApiCampaignSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Api Campaigns';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="api-campaign-index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
                <div class="api-campaign-index">

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <?php Pjax::begin(); ?>            <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            [
                                'class' => 'yii\grid\ActionColumn',
                                'header' => 'Action',
                                'template' => '{view}',
                            ],
                            [
                                'attribute' => 'adv_name',
                                'value' => 'adv.username',
                            ],

//                            'adv_update_time',
//                            'effective_time',
                            'campaign_id',
                            'campaign_uuid',
                             'campaign_name',
                            // 'pricing_mode',
                            // 'promote_start',
                            // 'end_time',
                            'platform',
                            'daily_cap',
                            'adv_price',
                            'daily_budget',
                            'target_geo',
                            // 'adv_link',
                            // 'traffice_source',
                            // 'note:ntext',
                            // 'preview_link',
                            // 'icon',
                            // 'package_name',
                            // 'app_name',
                            // 'app_size',
                            // 'category',
                            // 'version',
                            // 'app_rate',
                            // 'description',
                            // 'creative_link',
                            // 'creative_type',
                            // 'creative_description',
                            // 'carriers',
                            // 'conversion_flow',
                            // 'status',
                            // 'create_time:datetime',
                            // 'update_time:datetime',

                        ],
                    ]); ?>
                    <?php Pjax::end(); ?></div>
            </div>
        </div>
    </div>