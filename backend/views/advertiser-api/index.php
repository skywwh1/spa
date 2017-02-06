<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\AdvertiserApiSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Advertiser Apis';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="advertiser-api-index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
                <div class="advertiser-api-index">

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <p>
                        <?= Html::a('Create Advertiser Api', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>
                    <?php Pjax::begin(); ?>                                            <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],

                            'id',
                            'adv_id',
                            'url:url',
                            'key',
                            'param',
                            // 'json_offers_param',
                            // 'create_time:datetime',
                            // 'update_time:datetime',
                            // 'adv_update_time',
                            // 'effective_time',
                            // 'campaign_uuid',
                            // 'campaign_name',
                            // 'pricing_mode',
                            // 'promote_start',
                            // 'end_time',
                            // 'platform',
                            // 'daily_cap',
                            // 'adv_price',
                            // 'now_payout',
                            // 'target_geo',
                            // 'adv_link',
                            // 'traffice_source',
                            // 'note',
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

                            ['class' => 'yii\grid\ActionColumn',
                            'template'=>'{view}{update}'
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>                </div>
            </div>
        </div>
    </div>
