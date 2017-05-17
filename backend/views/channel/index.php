<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\export\ExportMenu;
/* @var $this yii\web\View */
/* @var $searchModel common\models\ChannelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Channel List';
$this->params['breadcrumbs'][] = $this->title;
$columns = [
    'id',
    'username',
    [
        'attribute' => 'om_name',
        'value' => 'om0.username',
    ],
    [
        'attribute' => 'master_channel_name',
        'value' => 'masterChannel.username',
    ],
    [
        'attribute' => 'os',
        'filter' => \common\models\Platform::find()
            ->select(['name', 'value'])
            ->orderBy('id')
            ->indexBy('value')
            ->column()
    ],
    'email:email',
    [
        'attribute' => 'status',
        'value' => function ($data) {
            return ModelsUtil::getAdvertiserStatus($data->status);
        },
        'filter' => ModelsUtil::advertiser_status,
    ],
    'total_revenue',
    'payable',
    'paid',
    [
        'attribute' => 'recommended',
        'value' => function ($data) {
            return ModelsUtil::getStatus($data->recommended);
        },
        'filter' => ModelsUtil::status,
    ],
    'note:text',
]
?>
<div class="row">
    <div id="nav-menu" data-menu="channel_index"></div>
    <div class="col-lg-12">
        <div class="box box-info table-responsive">
            <div class="box-body">
                <?php
                $fullExportMenu = ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $columns,
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

                <?php Pjax::begin(); ?>    <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'layout' => '{toolbar}{summary} {items} {pager}',
                    'toolbar' =>['{toggleData}',$fullExportMenu] ,
                    'toggleDataOptions' => [
                        '$type' => '$options',
                    ],
                    'columns' => [
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'template' => '{all}',
                            'header' => 'Action',
                            'buttons' => [
                                'all' => function ($url, $model, $key) {
                                    return '<div class="dropdown">
                          <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Actions
                          <span class="caret"></span></button>
                          <ul class="dropdown-menu">

                          <li><a data-view="0" href="/channel/view?id=' . $model->id . '">View</a></li>
                          <li><a href="/channel/update?id=' . $model->id . '" >Update</a></li>
                          <li><a data-pjax="0" href="/channel/recommend?id=' . $model->id . '">Recommend Offers</a></li>
                          </ul>
                        </div>';
                                },
                            ],
                        ],
                        'id',
                        'username',
                        [
                            'attribute' => 'om_name',
                            'value' => 'om0.username',
                        ],
                        [
                            'attribute' => 'master_channel_name',
                            'value' => 'masterChannel.username',
                        ],
                        [
                            'attribute' => 'os',
                            'filter' => \common\models\Platform::find()
                                ->select(['name', 'value'])
                                ->orderBy('id')
                                ->indexBy('value')
                                ->column()
                        ],
                        'email:email',
                        [
                            'attribute' => 'status',
                            'value' => function ($data) {
                                return ModelsUtil::getAdvertiserStatus($data->status);
                            },
                            'filter' => ModelsUtil::advertiser_status,
                        ],
                        'total_revenue',
                        'payable',
                        'paid',
                        [
                            'attribute' => 'recommended',
                            'value' => function ($data) {
                                return ModelsUtil::getStatus($data->recommended);
                            },
                            'filter' => ModelsUtil::status,
                        ],
                        'note:text',
                    ],
                ]); ?>
                <?php Pjax::end(); ?>
            </div>
        </div>
    </div>
</div>