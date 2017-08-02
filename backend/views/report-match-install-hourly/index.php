<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ReportMatchInstallHourlySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Campaign revenue';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="report-match-install-hourly-index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
<div class="report-match-install-hourly-index">

                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
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
                // 'label' => 'time',
                 'attribute' => 'time',
                 'value' => 'time',
            ],
            [ 
                // 'label' => 'advertiser_id',
                 'attribute' => 'advertiser_id',
                 'value' => 'advertiser_id',
            ],
            [ 
                // 'label' => 'installs',
                 'attribute' => 'installs',
                 'value' => 'installs',
            ],
            [ 
                // 'label' => 'installs_in',
                 'attribute' => 'installs_in',
                 'value' => 'installs_in',
            ],
            [
                 'label' => 'revenue',
                 'attribute' => 'revenue',
                 'value' => 'revenue',
            ],
            //[ 
                // 'label' => 'update_time',
                // 'attribute' => 'update_time',
                // 'value' => 'update_time:datetime',
           // ],
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