<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use kartik\datetime\DateTimePicker;
use yii\helpers\Url;
use yii\web\JsExpression;
use kartik\grid\GridView;
/* @var $this yii\web\View */
/* @var $model common\models\Campaign */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<h3>Update GEO</h3>
<?php $form = ActiveForm::begin([
    'id' => $model->formName(),
//    'enableAjaxValidation' => true,
    // 'validationUrl' => \yii\helpers\Url::toRoute('campaign-sts-update/validate'),
]); ?>

<?= $form->field($model, 'channel_id')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'campaign_id')->hiddenInput()->label(false) ?>

<?= $form->field($model, 'effect_time')->widget(DateTimePicker::classname(), [
    'type' => DateTimePicker::TYPE_INPUT,
//     'value' => isset($model->promote_end) ? date("Y-m-d", $model->promote_start) : '',
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd hh:ii',
//        'startDate' => date('Y-m-d h:i', strtotime("+1 day"))
    ],
    'readonly' => true,
]);
?>

<?php
echo $form->field($model, 'target_geo')->widget(Select2::classname(), [
    'size' => Select2::MEDIUM,
    'options' => [
        'multiple' => true,
    ],
    'pluginOptions' => [
        'allowClear' => true,
        'minimumInputLength' => 1,
        'language' => [
            'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
        ],
        'ajax' => [
            'url' => Url::to(['util/geo']),
            'dataType' => 'json',
            'data' => new JsExpression('function(params) { return {name:params.term}; }')
        ],
        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
        'templateResult' => new JsExpression('function(campaign) { return campaign.text; }'),
        'templateSelection' => new JsExpression('function (campaign) { return campaign.text; }'),
    ],
]);
?>
<?= $form->field($model, 'is_send')->dropDownList(['1' => 'Yes', '0' => "No"]) ?>
<?= GridView::widget([
    'id' => 'applying_list',
    'dataProvider' => $dataProvider,
    'pjax' => true, // pjax is set to always true for this demo
    'columns' => [
        'effect_time:datetime',
        'creator_name',
    ],
]); ?>
<div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>