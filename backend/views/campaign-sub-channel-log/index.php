<?php

use yii\helpers\Html;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CampaignSubChannelLogSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Campaign Sub Channel Logs';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="campaign-sub-channel-log-index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
            <div class="campaign-sub-channel-log-index">

                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
                <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                    'pjax' => true, // pjax is set to always true for this demo
                    'responsive' => true,
                    'hover' => true,
                'columns' => [
                    [
                        'class' => 'kartik\grid\ActionColumn',
                        'template' => '{diy}',
                        'buttons' => [
                            // 自定义按钮
                            'diy' => function ($url, $model, $key) {
                                $options = [
                                    'title' => Yii::t('yii', 'Update Status'),
                                    'aria-label' => Yii::t('yii', 'Update Status'),
                                    'data-pjax' => '0',
                                ];
                                if($model->is_effected == 1){
                                    $status = 0;
                                }else{
                                    $status = 1;
                                }
                                $url = '/campaign-sub-channel-log/turn?id=' . $model->id. '&is_effected='.$status;
                                return Html::a('<span class="glyphicon glyphicon-edit"></span>', $url, $options);
                            },
                        ]
                    ],
//            [
//                'attribute' => 'is_effected',
//                'value' => function ($model) {
//                    return ModelsUtil::getRedirectStatus($model->is_effected);
//                },
//                'filter' => ModelsUtil::receivable_status,
//            ],
//                    [
//                // 'label' => 'id',
//                 'attribute' => 'id',
//                 'value' => 'id',
//            ],
            [ 
                // 'label' => 'campaign_id',
                 'attribute' => 'campaign_id',
                 'value' => 'campaign_id',
            ],
            [ 
                // 'label' => 'channel_id',
                 'attribute' => 'channel_id',
                 'value' => 'channel_id',
            ],
            [ 
                // 'label' => 'sub_channel',
                 'attribute' => 'sub_channel',
                 'value' => 'sub_channel',
            ],
            [
                'attribute' => 'is_effected',
                'value' => function ($model) {
                    return ModelsUtil::getRedirectStatus($model->is_effected);
                },
                'filter' => ModelsUtil::redirect_status,
            ],
            //[
                // 'label' => 'name',
                // 'attribute' => 'name',
                // 'value' => 'name',
           // ],
            //[ 
                // 'label' => 'is_effected',
                // 'attribute' => 'is_effected',
                // 'value' => 'is_effected',
           // ],
                    'effect_time:datetime',
            //[ 
                // 'label' => 'create_time',
                // 'attribute' => 'create_time',
                // 'value' => 'create_time:datetime',
           // ],
            //[ 
                // 'label' => 'creator',
                // 'attribute' => 'creator',
                // 'value' => 'creator',
           // ],

//        [
//        'class' => 'yii\grid\ActionColumn',
//        'header' => 'Action',
//        'template' => '{view}{update}{delete}',
//        ],
        ],
        ]); ?>
        </div>
</div>
</div>
</div>