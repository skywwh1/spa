<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\PaymentForm */
/* @var $form ActiveForm */
?>
<div class="form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'payment_way') ?>
        <?= $form->field($model, 'beneficiary_name') ?>
        <?= $form->field($model, 'bank_country') ?>
        <?= $form->field($model, 'bank_name') ?>
        <?= $form->field($model, 'bank_address') ?>
        <?= $form->field($model, 'swift') ?>
        <?= $form->field($model, 'account_nu_iban') ?>
    
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
    <?php ActiveForm::end(); ?>

</div><!-- _form -->
