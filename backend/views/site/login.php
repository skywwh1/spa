<?php
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>




<?PHP $form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'form-horizontal','placeholder'=>'email','type'=>'email'],
]);

?>


<?= $form->field($model, 'username')->input('text', ['class' => 'form-control', 'placeholder' => 'Username','autofocus' => true])->label(false) ?>
<!--    <span class="glyphicon glyphicon-envelope form-control-feedback"></span> -->
    <?= $form->field($model, 'password')->input('password', ['class' => 'form-control', 'placeholder' => 'Password'])->label(false) ?>
<!--    <span class="glyphicon glyphicon-lock form-control-feedback"></span> -->

    <?= $form->field($model, 'verifyCode')->label(false)->widget(Captcha::className(), [
        'template' => '<div class="row"><div class="col-lg-5">{image}</div><div class="col-lg-7">{input}</div></div>',
    ]) ?>

<div class="row">
    <div class="col-xs-8">
    </div>
    <!-- /.col -->
    <div class="col-xs-4">
        <button type="submit" class="btn btn-primary btn-block btn-flat">Sign In</button>
    </div>
    <!-- /.col -->
</div>


<?php ActiveForm::end() ?>
