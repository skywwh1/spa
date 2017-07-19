<?php

use kartik\grid\GridView;
use kartik\editable\Editable;
/* @var $this yii\web\View */
/* @var $searchModel common\models\QualityDynamicColumn */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $time_between string */
$this->title = 'Finance Pendings';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div id="nav-menu" data-menu="finance-pending-index"></div>
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-body">
                    <div class="finance-pending-index">
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'id' => 'pending-list',
                            'pjax' => false,
                            'columns' => [
                                'time',
                                'campaign_id',
                                'campaign.campaign_name',
                                'channel.username',
                                'sub_channel',
                                [
                                    'attribute' => 'name',
                                    'value' => 'name',
                                    'class'=>'kartik\grid\EditableColumn',
                                    'editableOptions'=>function ($model, $key, $index) use ($time_between){
                                        return [
                                            'asPopover' => false,
                                            'inputType' => Editable::INPUT_TEXTAREA,
                                            'formOptions' => ['action' => ['/channel-quality-report/update-column?campaign_id='.$model->campaign_id.'&channel_id='.$model->channel_id.'&time='.$time_between
                                                .'&name='.urlencode($model->name).'&index='.$index]],
                                        ];
                                    }
                                ],
                                'value',
                                [
                                    'class' => 'kartik\grid\ActionColumn',
                                    'template' => '{diy}',
                                    'buttons' => [
                                        // 自定义按钮
                                        'diy' => function ($url, $model, $key) use ($time_between){
                                            $options = [
                                                'title' => Yii::t('yii', 'delete'),
                                                'aria-label' => Yii::t('yii', 'delete'),
                                                'data-pjax' => '0',
                                            ];
                                            $url = '/channel-quality-report/delete?id=' . $model->id.'&time='.$time_between;
                                            return \yii\helpers\Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, $options);
                                        },
                                    ]
                                ],
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
$this->registerJsFile(
    '@web/js/finance-pending-campaign.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);