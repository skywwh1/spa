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
<?= $form->field($model, 'name')->hiddenInput(['value' => 'discount'])->label(false) ?>
<div class="row">
    <label class="col-sm-5">Old discount :</label>

    <div class="col-sm-7">
        <label><?= $model->old_value ?></label>
    </div>
    <?= $form->field($model, 'old_value')->hiddenInput()->label(false) ?>
</div>
<?= $form->field($model, 'value')->textInput(['type' => 'number', 'required' => "required",'min'=>"0", 'max'=>"99"])->label('new Discount') ?>
<?= GridView::widget([
    'id' => 'applying_list',
    'dataProvider' => $dataProvider,
    'pjax' => true, // pjax is set to always true for this demo
    'columns' => [
        'value',
        'effect_time:datetime',
        'creator_name',
    ],
]); ?>
<div class="form-group">
    <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>







