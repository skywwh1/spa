<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ChannelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $campaign \common\models\Campaign */

$this->title = $campaign->id . '-' . $campaign->campaign_name . '-' . 'Recommend Channel List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div id="nav-menu" data-menu="campaign_index"></div>
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body">


                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        'username',
                        [
                            'attribute' => 'om',
                            'value' => 'om0.username',
                            'filter' => false,
                        ],
                        [
                            'attribute' => 'os',
                            'value' => 'os',
                            'filter' => false,
                        ],
                        [
                            'attribute' => 'strong_geo',
                        ],
                        [
                            'attribute' => 'strong_category',
                        ],
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>