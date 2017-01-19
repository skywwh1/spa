<?php
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<?PHP $form = ActiveForm::begin([
    'id' => 'login-form',
    'options' => ['class' => 'form-horizontal'],
]);

?>
<fieldset class='text-center'>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">

            <?= $form->field($model, 'username')->input('text', ['class' => 'form-control spa_form', 'placeholder' => 'Username','autofocus' => true])->label(false) ?>
        </div>
        <div class="col-lg-1"></div>
    </div>
    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">

            <?= $form->field($model, 'password')->input('password', ['class' => 'form-control', 'placeholder' => 'Password'])->label(false) ?>
        </div>
        <div class="col-lg-1"></div>
    </div>

    <div class="row">
        <div class="col-lg-1"></div>
        <div class="col-lg-10">
            <?= $form->field($model, 'verifyCode')->label(false)->widget(Captcha::className(), [
                'template' => '<div class="row"><div class="col-lg-5">{image}</div><div class="col-lg-7">{input}</div></div>',
            ]) ?>
        </div>
        <div class="col-lg-1"></div>
    </div>
    <div class='text-center'>
        <!--   <div class='checkbox'>
               <label>
                   <input type='checkbox'>
                   Remember me on this computer
               </label>
           </div>-->
        <input type="submit" class="btn btn-default" value="Sign in">
        <?= Html::a('Sign up', ['signup'], ['class' => 'btn btn-default']) ?>
        <br>
        <?= Html::a('Forgot password?', ['forget']) ?>
    </div>
</fieldset>
<?php ActiveForm::end() ?>
