<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\IpTableSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Ip Tables';
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="ip-table-index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
                <div class="ip-table-index">

                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                    <p>
                        <?= Html::a('Create Ip Table', ['create'], ['class' => 'btn btn-success']) ?>
                    </p>
                    <?php Pjax::begin(); ?>                                            <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [

                            'id',
                            'name',
                            'value',
                            'mark',
                            'note:ntext',

                            ['class' => 'yii\grid\ActionColumn',
                                'template' => '{view}{update}',
                            ],
                        ],
                    ]); ?>
                    <?php Pjax::end(); ?>                </div>
            </div>
        </div>
    </div>
