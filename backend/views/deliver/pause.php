<?php

use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Deliver */

$this->title = 'Update S2S: ' . $model->channel->username . '-' . $model->campaign->campaign_uuid;
$this->params['breadcrumbs'][] = ['label' => 'Delivers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->campaign->campaign_uuid, 'url' => ['view', 'campaign_id' => $model->campaign_id, 'channel_id' => $model->channel_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<?php $form = ActiveForm::begin(); ?>

<?= $form->field($model, 'campaign_uuid')->textInput(['readonly' => true]) ?>
<?= $form->field($model, 'channel0')->textInput(['readonly' => true, 'value' => $model->channel->username]) ?>
<?= $form->field($model, 'channel_id')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'campaign_id')->hiddenInput()->label(false) ?>

<?= $form->field($model, 'end_time')->widget(DateTimePicker::classname(), [
    'type' => DateTimePicker::TYPE_INPUT,
//     'value' => isset($model->promote_end) ? date("Y-m-d", $model->promote_start) : '',
    'pluginOptions' => [
//        'autoclose' => true,
        'format' => 'yyyy-mm-dd hh:ii',
        'startDate' => date('Y-m-d h:i',strtotime("+1 day"))
    ],
    'readonly'=>true,
]);

?>
<?php // $form->field($model, 'is_send')->dropDownList(['0' => 'Yes', '1' => "No"]) ?>
<div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>







