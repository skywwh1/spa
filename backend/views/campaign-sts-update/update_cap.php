<?php

use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CampaignStsUpdate */

?>
<?php $form = ActiveForm::begin([
    'id' => $model->formName(),
//    'enableAjaxValidation' => true,
//    'validationUrl' => \yii\helpers\Url::toRoute('campaign-sts-update/validate'),
]); ?>

<?= $form->field($model, 'channel_id')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'campaign_id')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'name')->hiddenInput(['value' => 'cap'])->label(false) ?>
<div class="row">
    <label class="col-sm-2">Now cap :</label>

    <div class="col-sm-10">
        <label><?= $model->old_value ?></label>
    </div>
    <?= $form->field($model, 'old_value')->hiddenInput()->label(false) ?>
</div>
<?= $form->field($model, 'value')->textInput(['type' => 'number', 'required' => "required"])->label('new Cap') ?>
<?= $form->field($model, 'effect_time')->widget(DateTimePicker::classname(), [
    'type' => DateTimePicker::TYPE_INPUT,
    'value' => '',
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd hh:ii',
//        'startDate' => date('Y-m-d h:i', strtotime("+1 day"))
    ],
    'readonly' => true,
    'options' => ['required' => "required",],

]);
?>

<?= $form->field($model, 'is_send')->dropDownList(['1' => 'Yes', '0' => "No"]) ?>
<div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>







