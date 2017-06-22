<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\EventReportSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Event Report';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="event-report-index"></div>
<?php  echo $this->render('_search', ['model' => $searchModel]); ?>

<div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
<div class="log-event-hourly-index">


                <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                // 'label' => 'time',
                'attribute' => 'time',
                'value' => 'time:datetime',
            ],

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
                // 'label' => 'event',
                 'attribute' => 'event',
                 'value' => 'event',
            ],
            [
                 'label' => 'match_total',
                 'attribute' => 'match_total',
                 'value' => 'match_total',
            ],
            [
                 'label' => 'total',
                 'attribute' => 'total',
                 'value' => 'total',
            ],
            //[ 
                // 'label' => 'create_time',
                // 'attribute' => 'create_time',
                // 'value' => 'create_time:datetime',
           // ],


        ],
        ]); ?>
        </div>
</div>
</div>
</div>