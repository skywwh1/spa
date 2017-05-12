<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\bootstrap\Modal;
/* @var $this yii\web\View */
/* @var $searchModel common\models\MyCartSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'My Carts';
$this->params['breadcrumbs'][] = $this->title;

?>
<div id="nav-menu" data-menu="my-cart-index"></div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
                <div class="my-cart-index">

                <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    
                <p>
                    <button type="button" id = 'selectButton' class="btn btn-success">Selected</button>
                    <button type="button" id = 'deleteButton' class="btn btn-success">Delete</button>
                </p>
                <?= GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                        'id' => 'grid',
                'columns' => [
                ['class' => 'yii\grid\SerialColumn'],
                [
                    'class' => 'yii\grid\CheckboxColumn',
                    'header' => Html::checkBox('selection_all', false, [
                        'class' => 'select-on-check-all',
//                        'label' => 'Select',
                    ]),
                ],
                [
                // 'label' => 'id',
                 'attribute' => 'id',
                 'value' => 'id',
                ],
                [
                    // 'label' => 'campaign_id',
                     'attribute' => 'campaign_id',
                     'value' => 'campaign_id',
                ],
                [
                    // 'label' => 'campaign_name',
                     'attribute' => 'campaign_name',
                     'value' => 'campaign_name',
                ],
                [
                    // 'label' => 'target_geo',
                     'attribute' => 'target_geo',
                     'value' => 'target_geo',
                ],
                [
                    // 'label' => 'platform',
                     'attribute' => 'platform',
                     'value' => 'platform',
                ],
                [
                     'label' => 'payout',
                     'attribute' => 'payout',
                     'value' => 'payout',
                ],
                [
                     'label' => 'daily_cap',
                     'attribute' => 'daily_cap',
                     'value' => 'daily_cap',
                ],
                [
                     'label' => 'traffic_source',
                     'attribute' => 'traffic_source',
                     'value' => 'traffic_source',
                ],
                [
                     'label' => 'tag',
                     'attribute' => 'tag',
                     'value' => 'tag',
                ],
                [
                     'label' => 'direct',
                     'attribute' => 'direct',
                     'value' => 'direct',
                ],
                [
                     'label' => 'advertiser',
                     'attribute' => 'advertiser',
                     'value' => function($model){
                         return $model->advertiser0->username;
                     }
                ],
        ],
        ]); ?>
        </div>
</div>
</div>
</div>
    <?php Modal::begin([
        'id' => 'my-cart-modal',
        'size' => 'modal-lg',
//    'header' =>'00',
        'clientOptions' => [
            'backdrop' => 'static',
            'keyboard' => false,
        ],
    ]);
    echo '<div id="my-cart-content"></div>';
    Modal::end(); ?>
<?php
$this->registerJsFile(
    '@web/js/select-good-campaign.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>
