<?php

use yii\helpers\Html;
use yii\grid\GridView;
/* @var $this yii\web\View */
/* @var $searchModel common\models\MyCartSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var keys array */

$this->title = 'Good Campaigns';
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
                        <button type="button" id = 'emailButton' class="btn btn-primary">ExportEmail</button>
                        <?= Html::a('Cancel', ['cancel'], ['class' => 'btn btn-primary']) ?>
                    </p>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'id' => 'detailGrid',
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                // 'label' => 'campaign_id',
                                'attribute' => 'campaign_id',
                                'value' => 'campaign_id',
                                'filter' => false,
                            ],
                            [
                                // 'label' => 'campaign_name',
                                'attribute' => 'campaign_name',
                                'value' => 'campaign_name',
                                'filter' => false,
                            ],
                            [
                                // 'label' => 'target_geo',
                                'attribute' => 'target_geo',
                                'value' => 'target_geo',
                                'filter' => false,
                            ],
                            [
                                // 'label' => 'platform',
                                'attribute' => 'platform',
                                'value' => 'platform',
                                'filter' => false,
                            ],
                            [
                                'label' => 'payout',
                                'attribute' => 'payout',
                                'value' => 'payout',
                                'filter' => false,
                            ],
                            [
                                'label' => 'traffic_source',
                                'attribute' => 'traffic_source',
                                'value' => 'traffic_source',
                                'filter' => false,
                            ],
                            [
                                'label' => 'preview_link',
                                'attribute' => 'preview_link',
                                'value' => 'preview_link',
                                'filter' => false,
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
    </div>
<?php
$this->registerJsFile(
    '@web/js/show-good-campaign.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>