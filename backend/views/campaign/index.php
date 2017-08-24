<?php

use common\models\TrafficSource;
use kartik\export\ExportMenu;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\models\CampaignSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Campaign List';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div id="nav-menu" data-menu="campaign_index"></div>
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body">

                <?php // echo $this->render('_search', ['model' => $searchModel]);
                $gridColumns = [
                    [
                        'attribute' => 'tag',
                        'value' => function ($model) {
                            return ModelsUtil::getCampaignTag($model->tag);
                        },
                        'filter' => ModelsUtil::campaign_tag,
                    ],
                    [
                        'attribute' => 'direct',
                        'value' => function ($model) {
                            return ModelsUtil::getCampaignDirect($model->direct);
                        },
                        'filter' => ModelsUtil::campaign_direct,
                    ],
                    [
                        'attribute' => 'advertiser',
                        'value' => 'advertiser0.username',
                    ],
                    'id',
//                    [
//                        'attribute' => 'campaign_name',
//                        'value' => 'name',
//                    ],
                    'campaign_name',
                    'campaign_uuid',
                    'target_geo',
                    'platform',
                    [
                        'attribute' => 'now_payout',
                        'label' => 'Payout',
                    ],

                    'traffic_source',
                    'preview_link',

                    'daily_cap',
                    [
                        'attribute' => 'status',
                        'value' => function ($model) {
                            return ModelsUtil::getCampaignStatus($model->status);
                        },
                        'filter' => ModelsUtil::campaign_status,
                    ],
                    [
                        'attribute' => 'kpi',
                        'value' => function ($model) {
                            return $model->kpi;
                        },
                        'format' =>'raw'
                    ],
                    'note',
                    'others',
                    'pricing_mode',
                    'category',
                    'package_name',
                ];

                $fullExportMenu = ExportMenu::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => $gridColumns,
                    'fontAwesome' => true,
                    'showConfirmAlert' => false,
                    'pjaxContainerId' => 'sdfsdfdf',
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
                ]); ?>
                <p>
                    <button type="button" id = 'selectButton' class="btn btn-primary">Select</button>
                </p>
                <?php $form = \kartik\form\ActiveForm::begin(['id' => 'deliver-form']); ?>
                <?= $form->field($searchModel, 'ids')->hiddenInput()->label(false) ?>
                <?php \kartik\form\ActiveForm::end(); ?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'filterModel' => $searchModel,
                    'id' => 'grid',
                    'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
//                    'headerRowOptions' => ['class' => 'kartik-sheet-style'],
//                    'filterRowOptions' => ['class' => 'kartik-sheet-style'],
//                    'autoXlFormat' => true,
//                    'showPageSummary' => true,
                    'layout' => '{toolbar}{summary} {items} {pager}',
                    'toolbar' => [
                        '{toggleData}',
//                        '{export}',
                        $fullExportMenu,
                    ],
                    'export' => [
                        'fontAwesome' => true,
                        'showConfirmAlert' => false,
                        'target' => GridView::TARGET_BLANK,
                        'label' => 'Page',
                    ],
//                    'pjax' => true, // pjax is set to always true for this demo
//                    'pjaxSettings' => [
//                        'neverTimeout' => true,
//                        'options' => [
//                            'id' => 'kv-unique-id-1',
//                        ]
//                    ],
                    'responsive' => true,
                    'hover' => true,
                    'columns' => [
                        [
                            'class' => 'kartik\grid\ActionColumn',
                            'template' => '{all}',
                            'header' => 'Action',
                            'buttons' => [
                                'all' => function ($url, $model, $key) {
                                    $restart = '';
                                    if ($model->status != 1) {
                                        $restart = '<li><a data-pjax="0" data-view="1" data-url="/campaign/restart?id=' . $model->id . '">Restart</a></li>';
                                    }
                                    if (\Yii::$app->user->can('admin')
                                        || strcmp($model->advertiser0->pm , Yii::$app->user->id)==0
                                        || strcmp($model->advertiser0->bd , Yii::$app->user->id)==0) {
                                        return '<div class="dropdown">
                                          <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Actions
                                          <span class="caret"></span></button>
                                          <ul class="dropdown-menu">
                                          <li><a data-view="0" data-url="/campaign/view?id=' . $model->id . '">View</a></li>
                                          <li><a href="/campaign/update?id=' . $model->id . '" >Update</a></li>
                                          <li><a href="/campaign/recommend?id=' . $model->id . '" >Recommend Channels</a></li>
                                          <li><a href="/campaign/create?id=' . $model->id . '" >Copy Campaign</a></li>
                                          <li><a data-pjax="0" data-view="1" data-url="/campaign-sts-update/pause?type=1&channel_id=&campaign_id=' . $model->id . '">Paused</a></li>
                                          <li><a data-pjax="0" data-view="1" data-url="/campaign-sts-update/update-geo?type=1&channel_id=&campaign_id=' . $model->id . '">GEO Updates</a></li>
                                          <li><a data-pjax="0" data-view="1" data-url="/campaign-sts-update/update-creative?type=1&channel_id=&campaign_id=' . $model->id . '">Creative Updates</a></li>
                                          <li><a data-pjax="0" data-view="1" data-url="/campaign-sts-update/update-price?campaign_id=' . $model->id . '">Price Updates</a></li>
                                          <li><a data-pjax="0" data-view="1" data-url="/my-cart/add-my-cart?campaign_id=' . $model->id . '">Add to Cart</a></li>
                                          <li><a data-view="0" data-url="/deliver/send-sts-email?campaign_id=' . $model->id . '">Send Email</a></li>' .
                                            $restart
                                            . '</ul>
                                        </div>';
                                    }  else {
                                        return '<div class="dropdown">
                                          <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">Actions
                                          <span class="caret"></span></button>
                                          <ul class="dropdown-menu">
                                          <li><a data-view="0" data-url="/campaign/view?id=' . $model->id . '">View</a></li>
                                          <li><a data-pjax="0" data-view="1" data-url="/my-cart/add-my-cart?campaign_id=' . $model->id . '">Add to Cart</a></li>'.
                                            $restart
                                            . '</ul>
                                    </div>';
                                    }
                                },
                            ],
                        ],
                        [
                            'class' => 'yii\grid\CheckboxColumn',
                            'header' => Html::checkBox('selection_all', false, [
                                'class' => 'select-on-check-all',
                                'label' => 'Select',
                            ]),
                        ],
                        [
                            'attribute' => 'tag',
                            'value' => function ($model) {
                                return ModelsUtil::getCampaignTag($model->tag);
                            },
                            'filter' => ModelsUtil::campaign_tag,
                            'class'=>'kartik\grid\EditableColumn',
                            'editableOptions'=>function ($model) {
                                return [
                                    'inputType'=>\kartik\editable\Editable::INPUT_DROPDOWN_LIST,
                                    'asPopover' => false,
                                    'data' => ModelsUtil::campaign_tag,
                                    'formOptions' => ['action' => ['/campaign/update-tag']],
                                ];
                            },
                            'contentOptions' => function ($model) {
                                if ($model->tag == 3) {
                                    return ['class' => 'bg-danger'];
                                } else if ($model->tag == 2) {
                                    return ['class' => 'bg-warning'];
                                } else if ($model->tag == 4) {
                                    return ['class' => 'bg-info'];
                                } else if ($model->tag == 5) {
                                    return ['class' => 'bg-gray'];
                                }
                                else {
                                    return ['class' => 'bg-success'];
                                }
                            },
                        ],
                        [
                            'attribute' => 'direct',
                            'value' => function ($model) {
                                return ModelsUtil::getCampaignDirect($model->direct);
                            },
                            'filter' => ModelsUtil::campaign_direct,
//                            'contentOptions' => function ($model) {
//                                if ($model->tag == 3) {
//                                    return ['class' => 'bg-danger'];
//                                } else if ($model->tag == 2) {
//                                    return ['class' => 'bg-warning'];
//                                } else {
//                                    return ['class' => 'bg-success'];
//                                }
//                            }
                        ],
                        'id',
                        [
                            'attribute' => 'advertiser',
                            'value' => 'advertiser0.username',
//                                'pageSummary' => 'Total'
                        ],
                        'campaign_uuid',
                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'campaign_name',
                            'value' => function ($data) {
                                return Html::tag('div', $data->name, ['data-toggle' => 'tooltip', 'data-placement' => 'left', 'title' => $data->campaign_name, 'data-delay' => '{"show":0, "hide":3000}', 'style' => 'cursor:default;']);
                            },
                            'width' => '60px',
                            'format' => 'raw',
                        ],
                        //'target_geo',
                        [
                            'class' => '\kartik\grid\DataColumn',
                            'attribute' => 'target_geo',
                            'value' => function ($data) {
                                return Html::tag('div', $data->geo, ['data-toggle' => 'tooltip', 'data-placement' => 'left', 'title' => $data->target_geo, 'data-delay' => '{"show":0, "hide":5000}', 'style' => 'cursor:default;']);
                            },
                            'width' => '60px',
                            'format' => 'raw',
                        ],
//                    'device',
                        'platform',
//                        'adv_price',
                        [
                            'attribute' => 'adv_price',
//                            'pageSummary' => true
                        ],
                        'now_payout',
                        [
                            'attribute' => 'traffic_source',
                            'value' => 'traffic_source',
                            'filter' => TrafficSource::find()
                                ->select(['name', 'value'])
                                ->orderBy('id')
                                ->indexBy('value')
                                ->column(),
                        ],
                        // 'traffic_source',
                        // 'note',
//                        'preview_link',
                        // 'icon',
                        // 'package_name',
                        // 'app_name',
                        // 'app_size',

                        // 'version',
                        // 'app_rate',
                        // 'description',
                        // 'creative_link',
                        // 'creative_type',
                        // 'creative_description',
                        // 'carriers',
                        // 'conversion_flow',
                        // 'recommended',

                        'daily_cap',
//                        'cvr',
//                        'epc',
                        [
                            'attribute' => 'status',
                            'value' => function ($model) {
                                return ModelsUtil::getCampaignStatus($model->status);
                            },
                            'filter' => Html::activeDropDownList($searchModel, 'status',
                                ModelsUtil::campaign_status, ['class' => 'form-control']),
                        ],
                        'pricing_mode',
                        'category',
                        'package_name',
                    ],
                ]); ?>
            </div>
        </div>
    </div>
</div>
<?php
$this->registerJsFile(
    '@web/js/campaign.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>
<?php Modal::begin([
    'id' => 'campaign-modal',
    'size' => 'modal-lg',
//    'header' =>'00',
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false,
    ],

]);
echo '<div id="campaign-detail-content"></div>';
Modal::end(); ?>

<?php Modal::begin([
    'id' => 'campaign-update-modal',
    'size' => 'modal-sm',
//    'header' =>'00',
    'clientOptions' => [
        'backdrop' => 'static',
        'keyboard' => false,
    ],
]);

echo '<div id="campaign-update-content"></div>';

Modal::end(); ?>

