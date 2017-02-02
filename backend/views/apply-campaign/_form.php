<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ApplyCampaign */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="apply-campaign-form">

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
    <?= $form->field($model, 'status')->textInput() ?>
   </div>
 </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'create_time')->textInput() ?>
   </div>
 </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
