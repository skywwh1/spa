<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Campaign report';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-lg-12">
    <div class="box box-info table-responsive">
        <div class="box-body">
            <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

            <?php Pjax::begin(); ?>    <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-striped table-bordered table-hover'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    [
                        'attribute'=>'campaign_id',
                        'value'=>'campaign.campaign_name',
                        'label'=>'Campaign Name',
                    ],
//                    'campaign.campaign_name',
                    'campaign_uuid',
                    [
                        'attribute'=>'channel_id',
                        'value'=>'channel.username',
                        'label'=>'Channel Name',
                    ],
                    'click',
                    'unique_click',
                    'install',
                    'cvr',
                    'campaign.avg_price',
                    'cost',
                    'match_install',
                    'match_cvr',
                    'adv_price',
                    'revenue',
                    'def',
                    'deduction_percent',
                    'profit',
                    'margin',
//            'pricing_mode',
//            'pay_out',
//            'daily_cap',
                    // 'actual_discount',
                    'note',

                    //['class' => 'yii\grid\ActionColumn'],
                    // 'track_url:url',
                    // 'update_time:datetime',
                    // 'create_time:datetime',
                    // 'creator',
                    // 'is_run',
                    'discount',
                ],
            ]); ?>
            <?php Pjax::end(); ?>

        </div>
    </div>
</div>