<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

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
<?= $form->field($model, 'pay_out')->textInput() ?>
<?= $form->field($model, 'daily_cap')->textInput() ?>
<?= $form->field($model, 'discount')->textInput() ?>
<?= $form->field($model, 'is_run')->dropDownList(ModelsUtil::status) ?>

<div class="form-group">
    <?= Html::submitButton('Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
</div>

<?php ActiveForm::end(); ?>
