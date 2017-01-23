<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Delivers';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-lg-12">
    <div class="box box-info ">
        <div class="box-body table-responsive">
            <?php //echo $this->render('_search', ['model' => $searchModel]); ?>

            <?php Pjax::begin(); ?>    <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'tableOptions' => ['class' => 'table table-striped table-bordered'],
                'columns' => [
                    ['class' => 'yii\grid\SerialColumn'],

                    'campaign.campaign_name',
                    'campaign_uuid',
                    'channel.username',
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