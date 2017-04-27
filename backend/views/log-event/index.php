<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\LogEventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Log Events';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="log-event-index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
<div class="log-event-index">

                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <p>
        <?= Html::a('Create Log Event', ['create'], ['class' => 'btn btn-success']) ?>
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
                // 'label' => 'click_uuid',
                 'attribute' => 'click_uuid',
                 'value' => 'click_uuid',
            ],
            [ 
                // 'label' => 'auth_token',
                 'attribute' => 'auth_token',
                 'value' => 'auth_token',
            ],
            [ 
                // 'label' => 'channel_id',
                 'attribute' => 'channel_id',
                 'value' => 'channel_id',
            ],
            [ 
                // 'label' => 'event_name',
                 'attribute' => 'event_name',
                 'value' => 'event_name',
            ],
            //[ 
                // 'label' => 'event_value',
                // 'attribute' => 'event_value',
                // 'value' => 'event_value',
           // ],
            //[ 
                // 'label' => 'create_time',
                // 'attribute' => 'create_time',
                // 'value' => 'create_time:datetime',
           // ],
            //[ 
                // 'label' => 'update_time',
                // 'attribute' => 'update_time',
                // 'value' => 'update_time:datetime',
           // ],
            //[ 
                // 'label' => 'ip',
                // 'attribute' => 'ip',
                // 'value' => 'ip',
           // ],
            //[ 
                // 'label' => 'ip_long',
                // 'attribute' => 'ip_long',
                // 'value' => 'ip_long',
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