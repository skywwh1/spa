<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Deliver */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="deliver-form">

    <?php $form = ActiveForm::begin(); ?>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'campaign_id')->textInput() ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'channel_id')->textInput() ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'pricing_mode')->textInput() ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'pay_out')->textInput() ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'daily_cap')->textInput() ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'discount')->textInput() ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'is_run')->textInput() ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'creator')->textInput() ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'create_time')->textInput() ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'update_time')->textInput() ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>
   </div>
 </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
