<?php

use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Deliver */

?>
<h3>Pause campaign</h3>
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

<?= $form->field($model, 'is_send')->dropDownList(['1' => 'Yes', '0' => "No"]) ?>
<div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>







