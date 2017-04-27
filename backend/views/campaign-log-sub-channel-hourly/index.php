<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ReportSubChannelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Campaign Log Sub Channel Hourlies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="campaign-log-sub-channel-hourly-index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
<div class="campaign-log-sub-channel-hourly-index">

                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <p>
        <?= Html::a('Create Campaign Log Sub Channel Hourly', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
                <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

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
                // 'label' => 'time',
                 'attribute' => 'time',
                 'value' => 'time:datetime',
            ],
            [ 
                // 'label' => 'time_format',
                 'attribute' => 'time_format',
                 'value' => 'time_format',
            ],
            //[ 
                // 'label' => 'clicks',
                // 'attribute' => 'clicks',
                // 'value' => 'clicks',
           // ],
            //[ 
                // 'label' => 'unique_clicks',
                // 'attribute' => 'unique_clicks',
                // 'value' => 'unique_clicks',
           // ],
            //[ 
                // 'label' => 'installs',
                // 'attribute' => 'installs',
                // 'value' => 'installs',
           // ],
            //[ 
                // 'label' => 'match_installs',
                // 'attribute' => 'match_installs',
                // 'value' => 'match_installs',
           // ],
            //[ 
                // 'label' => 'redirect_installs',
                // 'attribute' => 'redirect_installs',
                // 'value' => 'redirect_installs',
           // ],
            //[ 
                // 'label' => 'redirect_match_installs',
                // 'attribute' => 'redirect_match_installs',
                // 'value' => 'redirect_match_installs',
           // ],
            //[ 
                // 'label' => 'pay_out',
                // 'attribute' => 'pay_out',
                // 'value' => 'pay_out',
           // ],
            //[ 
                // 'label' => 'adv_price',
                // 'attribute' => 'adv_price',
                // 'value' => 'adv_price',
           // ],
            //[ 
                // 'label' => 'daily_cap',
                // 'attribute' => 'daily_cap',
                // 'value' => 'daily_cap',
           // ],
            //[ 
                // 'label' => 'cap',
                // 'attribute' => 'cap',
                // 'value' => 'cap',
           // ],
            //[ 
                // 'label' => 'cost',
                // 'attribute' => 'cost',
                // 'value' => 'cost',
           // ],
            //[ 
                // 'label' => 'redirect_cost',
                // 'attribute' => 'redirect_cost',
                // 'value' => 'redirect_cost',
           // ],
            //[ 
                // 'label' => 'revenue',
                // 'attribute' => 'revenue',
                // 'value' => 'revenue',
           // ],
            //[ 
                // 'label' => 'redirect_revenue',
                // 'attribute' => 'redirect_revenue',
                // 'value' => 'redirect_revenue',
           // ],
            //[ 
                // 'label' => 'create_time',
                // 'attribute' => 'create_time',
                // 'value' => 'create_time:datetime',
           // ],

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