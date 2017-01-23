<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CampaignSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Campaign List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-12">
    <div class="box box-info table-responsive">
        <div class="box-body">

            <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

            <?php Pjax::begin(); ?>    <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'id',
                    'advertiser',
                    'campaign_name',
                    'tag',
                    'campaign_uuid',
                    'pricing_mode',
                    'indirect',
                    'category',
                    'target_geo',
//             'promote_start',
                    // 'promote_end',
                    // 'end_time:datetime',
                    'device',
                    'platform',
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
                    'status',

                    ['class' => 'yii\grid\ActionColumn'],
                ],
            ]); ?>
            <?php Pjax::end(); ?>
        </div>
    </div>
</div>