<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel common\models\CampaignStsUpdateSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Payout Log';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="campaign-sts-update-index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
                <div class="campaign-sts-update-index">

                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <!--<p>
        <?/*= Html::a('Create Campaign Sts Update', ['create'], ['class' => 'btn btn-success']) */?>
    </p>-->
    <?php Pjax::begin(); ?>            <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

                    'id',
//            'campaign_id',
            [
                'attribute' => 'campaign_id',
                'value' => 'campaign_id',
                'filter' => true,
            ],
            [
                'attribute' => 'channel_id',
                'value' =>'channel_id',
                'filter' => true,
            ],
            [
                'attribute' => 'campaign_name',
                'value' => 'campaign_name',
//                'filter' => true,
            ],
            [
                'attribute' => 'channel_name',
                'value' => 'channel_name',
//                'filter' => true,
            ],
//            'channel_id',
            [
                'attribute' => 'name',
                'value' => 'name',
                'filter' => false,
            ],
            [
                'attribute' => 'value',
                'value' =>  'value',
                'filter' => false,
            ],
            [
                'attribute' => 'old_value',
                'value' => 'old_value',
                'filter' => false,
            ],
//            'value',
//            'old_value',
            [
                'attribute' => 'type',
                'value' => function ($model) {
                    return ModelsUtil::getUpdateType($model->type);
                },
                'filter' => ModelsUtil::update_type,
            ],
//            'send_time:datetime',
//            [
//                'label' => 'send_time',
//                'value' => function ($model) {
//                    return date('Y-m-d h:i',$model->send_time);
//                },
//            ],
//           'is_effected',
            [
                'attribute' => 'is_effected',
                'value' => function ($model) {
                    return ModelsUtil::getEffectType($model->is_effected);
                },
                'filter' => ModelsUtil::effect_type,
            ],
//            'effect_time:datetime',
            [
                'label' => 'effect_time',
                'attribute' => 'effect_time',
                'value' => function ($model) {
                   return date('Y-m-d h:i',$model->effect_time);
                },
                'filter' => false,
            ],
//            'create_time:datetime',
            [
                'label' => 'create_time',
                'attribute' => 'create_time',
                'value' => function ($model) {
                    return date('Y-m-d h:i',$model->create_time);
                },
                'filter' => false,
            ],

        /*[
        'class' => 'yii\grid\ActionColumn',
        'header' => 'Action',
        'template' => '{view}{update}{delete}',
        ],*/
        ],
        ]); ?>
        <?php Pjax::end(); ?></div>
</div>
</div>
</div>