<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\StreamSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Streams';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="stream-index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
<div class="stream-index">

                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <?php Pjax::begin(); ?>            <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [

                    'id',
            'click_uuid',
            'cp_uid',
            'ch.username',
            // 'pl',
            // 'tx_id',
            // 'all_parameters',
            // 'ip',
            // 'redirect',
            // 'browser',
            // 'browser_type',
            // 'post_link',
            // 'post_status',
            // 'post_time:datetime',
            // 'is_count',
            // 'create_time:datetime',

        [
        'class' => 'yii\grid\ActionColumn',
        'header' => 'Action',
        'template' => '{view}',
        ],
        ],
        ]); ?>
        <?php Pjax::end(); ?></div>
</div>
</div>
</div>