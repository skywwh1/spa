<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ChannelSubWhitelistSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Channel Sub Whitelists';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="channel-sub-whitelist-index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
<div class="channel-sub-whitelist-index">

                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <p>
        <?= Html::a('Create Channel Sub Whitelist', ['create'], ['class' => 'btn btn-success']) ?>
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
                // 'label' => 'geo',
                 'attribute' => 'geo',
                 'value' => 'geo',
            ],
            [ 
                // 'label' => 'os',
                 'attribute' => 'os',
                 'value' => 'os',
            ],
            //[ 
                // 'label' => 'category',
                // 'attribute' => 'category',
                // 'value' => 'category',
           // ],
            //[ 
                // 'label' => 'note',
                // 'attribute' => 'note',
                // 'value' => 'note:ntext',
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