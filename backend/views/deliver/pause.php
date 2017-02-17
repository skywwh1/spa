<?php

use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Deliver */

?>
<?php $form = ActiveForm::begin(); ?>

<?php // $form->field($model, 'channel_id')->textInput(['readonly' => true])  ?>
<?php // $form->field($model, 'campaign_id')->textInput(['readonly' => true])  ?>

<?= $form->field($model, 'effect_time')->widget(DateTimePicker::classname(), [
    'type' => DateTimePicker::TYPE_INPUT,
//     'value' => isset($model->promote_end) ? date("Y-m-d", $model->promote_start) : '',
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd hh:ii',
        'startDate' => date('Y-m-d h:i',strtotime("+1 day"))
    ],
    'readonly'=>true,
]);
?>

<?=  $form->field($model, 'is_send')->dropDownList(['0' => 'Yes', '1' => "No"]) ?>
<div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>







