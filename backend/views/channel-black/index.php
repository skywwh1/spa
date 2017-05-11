<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ChannelBlackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Channel Blacks';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="channel-black-index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
<div class="channel-black-index">

                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <p>
        <?= Html::a('Create', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
                <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

                    [ 
                // 'label' => 'id',
                 'attribute' => 'id',
                 'value' => 'id',
            ],
            [ 
                // 'label' => 'advertiser',
                 'attribute' => 'advertiser_name',
                 'value' => 'advertiser_name',
            ],
            [ 
                // 'label' => 'channel_id',
                 'attribute' => 'channel_id',
                 'value' => 'channel_id',
            ],
//            [
//                // 'label' => 'campaign_id',
//                 'attribute' => 'campaign_id',
//                 'value' => 'campaign_id',
//            ],
//            [
//                'attribute' => 'campaign_name',
//                'value' => 'campaign_name',
//            ],
            [
                'attribute' => 'channel_name',
                'value' => 'channel_name',
            ],
            [ 
                // 'label' => 'geo',
                 'attribute' => 'geo',
                 'value' => 'geo',
                 'filter'=> false,
            ],
            [
                 'attribute' => 'os',
                 'value' => 'os',
                'filter'=> false,
            ],
            [
                'attribute' => 'action_type',
                'value' => function ($model) {
                    return ModelsUtil::getBlackAction($model->action_type);
                },
                'filter' => ModelsUtil::black_action,
            ],
            [
                 'label' => 'note',
                 'attribute' => 'note',
//                 'value' => 'note:ntext',
            ],

        [
        'class' => 'yii\grid\ActionColumn',
        'header' => 'Action',
        'template' => '{view}{update}{delete}',
        ],
        ],
        ]); ?>
        </div>
</div>
</div>
</div>