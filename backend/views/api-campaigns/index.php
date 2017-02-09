<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ApiCampaignsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Api Campaigns';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="api-campaigns-index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
                <div class="api-campaigns-index">

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
//                        ['class' => 'yii\grid\SerialColumn'],
//
//                                    'id',
                            'adv_id',
//            'username',
//            'password',
//            'url:url',
                            // 'key',
                            // 'param',
                            // 'json_offers_param',
                            'adv_update_time',
                            'effective_time',
                            'adv_campaign_id',
//                            'campaign_uuid',
                            'campaign_name',
                            'pricing_mode',
                            'promote_start',
                            'end_time',
                            'platform',
                            'daily_cap',
                            'adv_price',
                            'daily_budget',
                            'target_geo',
//                            'adv_link',
//                            'traffice_source',
//                            'note:ntext',
//                            'preview_link',
//                            'icon',
//                            'package_name',
//                            'app_name',
//                            'app_size',
//                            'category',
//                            'version',
//                            'app_rate',
//                            'description',
//                            'creative_link',
//                            'creative_type',
//                            'creative_description',
//                            'carriers',
//                            'conversion_flow',
                            'status',
                            // 'create_time:datetime',
                            // 'update_time:datetime',

                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
