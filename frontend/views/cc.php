<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ChannelSignupForm */
/* @var $form ActiveForm */
?>
<div class="cc">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'username') ?>
        <?= $form->field($model, 'email') ?>
        <?= $form->field($model, 'company') ?>
        <?= $form->field($model, 'timezone') ?>
        <?= $form->field($model, 'phone1') ?>
        <?= $form->field($model, 'skype') ?>
        <?= $form->field($model, 'country') ?>
        <?= $form->field($model, 'address') ?>
        <?= $form->field($model, 'vertical') ?>
        <?= $form->field($model, 'offer_type') ?>
        <?= $form->field($model, 'other_network') ?>
        <?= $form->field($model, 'vertical_interested') ?>
        <?= $form->field($model, 'special_offer') ?>
        <?= $form->field($model, 'regions') ?>
        <?= $form->field($model, 'traffic_type') ?>
        <?= $form->field($model, 'best_time') ?>
        <?= $form->field($model, 'time_zone') ?>
        <?= $form->field($model, 'suggested_am') ?>
        <?= $form->field($model, 'additional_notes') ?>
        <?= $form->field($model, 'another_info') ?>
        <?= $form->field($model, 'id') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- cc -->
