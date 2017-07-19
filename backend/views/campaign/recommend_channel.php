<?php

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel common\models\ChannelSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $campaign \common\models\Campaign */
/* @var $model backend\models\StsForm */


$this->title = $campaign->id . '-' . $campaign->campaign_name . '-' . 'Recommend Channel List';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="row">
        <div id="nav-menu" data-menu="campaign_index"></div>
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-body">
                    <?php $form = ActiveForm::begin([
                        'action' => ['/deliver/recommend-create'],
                        'method' => 'post',
                        'id'=>'recommend-form'
                    ]); ?>
                    <?= Html::activeHiddenInput($model, 'campaign_uuid', ['value' => $campaign->id]) ?>
                    <?= Html::activeHiddenInput($model, 'channel') ?>
                    <?php ActiveForm::end(); ?>

                    <p>
                        <?= Html::button('S2S', ['class' => 'btn btn-primary', 'id' => 's2s_button']) // echo $this->render('_search', ['model' => $searchModel]);    ?>

                    </p>

                    <?php Pjax::begin(); ?>    <?= GridView::widget([
                        'id' => 'recommend-list',
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            [
                                'class' => '\kartik\grid\CheckboxColumn'
                            ],
                            [
                                'attribute' => 'level',
                                'value' => function ($model) {
                                    return ModelsUtil::getChannelLevel($model->level);
                                },
                                'filter' => ModelsUtil::channel_level
                            ],
                            [
                                'attribute' => 'create_type',
                                'value' => function ($model) {
                                    return ModelsUtil::getChannelCreateType($model->create_type);
                                },
                                'filter' => ModelsUtil::channel_create_type
                            ],
                            'username',
                            [
                                'attribute' => 'om_name',
                                'value' => 'om0.username',
                            ],
                            [
                                'attribute' => 'os',
                                'value' => 'os',
                                'filter' => false,
                            ],
                            [
                                'attribute' => 'strong_geo',
                                'filter' => false,
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
<?php
$this->registerJsFile(
    '@web/js/recommend-channel.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>