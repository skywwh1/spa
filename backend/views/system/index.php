<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SystemSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Third-party Systems';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="system-index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
<div class="system-index">

                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
    <p>
        <?= Html::a('Create System', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
                <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
                    [
                // 'label' => 'id',
                 'attribute' => 'id',
                 'value' => 'id',
            ],
            [
                // 'label' => 'name',
                 'attribute' => 'name',
                 'value' => 'name',
            ],
            [ 
                // 'label' => 'post_parameter',
                 'attribute' => 'post_parameter',
                 'value' => 'post_parameter',
            ],
            [ 
                // 'label' => 'mark',
                 'attribute' => 'mark',
                 'value' => 'mark',
            ],
            [
                 'label' => 'note',
                 'attribute' => 'note',
                 'value' => 'note',
            ],

        [
        'class' => 'yii\grid\ActionColumn',
        'header' => 'Action',
        'template' => '{view}{update}',
        ],
        ],
        ]); ?>
        </div>
</div>
</div>
</div>