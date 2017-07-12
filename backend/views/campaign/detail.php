<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel common\models\CampaignSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $keys array */

$this->title = 'Selected Campaigns';
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
                        <button type="button" id = 'stsButton' class="btn btn-primary">S2S</button>
                        <button type="button" id = 'cartButton' class="btn btn-primary">Add to my cart</button>
                    </p>
                    <?php $form = \kartik\form\ActiveForm::begin(['id' => 'deliver-form']); ?>
                    <?= $form->field($searchModel, 'campaign_uuid')->hiddenInput()->label(false) ?>
                    <?php \kartik\form\ActiveForm::end(); ?>
                    <?php
                    $systemColumns =  [
                        [
                            // 'label' => 'campaign_id',
                            'attribute' => 'id',
                            'value' => 'id',
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
//                                'label' => 'now_payout',
                            'attribute' => 'now_payout',
                            'value' => 'now_payout',
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
                    ];
                    echo ExportMenu::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => $systemColumns,
                        'fontAwesome' => true,
                        'showConfirmAlert' => false,
                        'target' => GridView::TARGET_BLANK,
                        'dropdownOptions' => [
                            'label' => 'Export All',
                            'class' => 'btn btn-default'
                        ],
                        'exportConfig' => [
                            ExportMenu::FORMAT_TEXT => false,
                            ExportMenu::FORMAT_PDF => false,
                            ExportMenu::FORMAT_EXCEL_X => false,
                            ExportMenu::FORMAT_HTML => false,
                        ],
                    ]);
                    ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
//                        'pjax' => true,
                        'id' => 'detailGrid',
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                // 'label' => 'campaign_id',
                                'attribute' => 'id',
                                'value' => 'id',
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
//                                'label' => 'now_payout',
                                'attribute' => 'now_payout',
                                'value' => 'now_payout',
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