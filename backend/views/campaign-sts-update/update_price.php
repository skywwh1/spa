<?php

use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\CampaignStsUpdate */
/* @var $dataProvider yii\data\ActiveDataProvider */
?>
<?php $form = ActiveForm::begin([
    'id' => $model->formName(),
//    'enableAjaxValidation' => true,
//    'validationUrl' => \yii\helpers\Url::toRoute('campaign-sts-update/validate'),
]); ?>

<?= $form->field($model, 'channel_id')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'campaign_id')->hiddenInput()->label(false) ?>
<div class="row">
    <label class="col-sm-5">Now Price :</label>

    <div class="col-sm-7">
        <label><?= $model->adv_price_old ?></label>
    </div>
</div>
<?= $form->field($model, 'adv_price')->textInput(['type' => 'number', 'required' => "required", 'min' => '0','step'=>'any'])->label('New Price') ?>
<div class="row">
    <label class="col-sm-5">Now Payout :</label>

    <div class="col-sm-7">
        <label><?= $model->pay_out_old ?></label>
    </div>
</div>
<?= $form->field($model, 'pay_out')->textInput(['type' => 'number', 'required' => "required", 'min' => '0','step'=>'any'])->label('New Payout') ?>
<?= $form->field($model, 'effect_time')->widget(DateTimePicker::classname(), [
    'type' => DateTimePicker::TYPE_INPUT,
    'value' => '',
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd hh:ii',
        // 'startDate' => date('Y-m-d h:i', strtotime("+1 day"))
    ],
    'readonly' => true,
    'options' => ['required' => "required",],

]);
?>
<?= GridView::widget([
    'id' => 'applying_list',
    'dataProvider' => $dataProvider,
    'pjax' => true, // pjax is set to always true for this demo
    'columns' => [
        'action',
        'value',
        'effect_time:datetime',
        'creator_name',
    ],
]); ?>
<div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>







