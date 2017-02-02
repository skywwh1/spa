<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ChannelRegister */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="channel-register-form">

    <?php $form = ActiveForm::begin(); ?>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'channel_id')->textInput() ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'vertical')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'offer_type')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'other_network')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'vertical_interested')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'special_offer')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'regions')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'traffic_type')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'best_time')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'time_zone')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'suggested_am')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'additional_notes')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'another_info')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
