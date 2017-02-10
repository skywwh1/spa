<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\DeliverSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'S2S Log';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="deliver_index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">

                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'columns' => [
                      //  ['class' => 'yii\grid\SerialColumn'],
                        [
                                'attribute'=>'campaign.campaign_name',
                                'filter'=>true
                        ],
//                        'campaign.campaign_name',
                        'channel.username',
                        'pricing_mode',
                        'pay_out',
                        'daily_cap',
                         'discount',
                        // 'is_run',
                        // 'creator',
                         'create_time:datetime',
                        // 'update_time:datetime',
                        // 'track_url:url',
                        // 'note',

                        ['class' => 'yii\grid\ActionColumn',
                        'template'=>'{view}{update}'
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>