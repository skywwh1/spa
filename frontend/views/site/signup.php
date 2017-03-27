<?php

/* @var $this yii\web\View */

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="tact-con">
        <img src="<?= Yii::getAlias('@web/new/img/signup-bg.png') ?>" alt=""/>
        <div class="sign-left">
            <h1><strong>S</strong>ign<strong>U</strong>p</h1>
            <div class="p">
                <p>Please select your role in the following options.</p>
            </div>
            <div class="choose">
                <ul>
                    <li>
                        <img src="<?= Yii::getAlias('@web/new/img/choose.png') ?>"/>
                        <p>Publisher</p>
                    </li>
                </ul>
            </div>
        </div>
        <div class="sign-right">
            <div class="sign-table">
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'company')->textInput(['placeholder'=>'Company'])->label(false) ?>
                <?= $form->field($model, 'username')->textInput(['placeholder'=>'Username'])->label(false) ?>
                <?= $form->field($model, 'email')->textInput(['placeholder'=>'Email'])->label(false) ?>
                <?= $form->field($model, 'password_hash')->passwordInput(['placeholder'=>'Password'])->label(false) ?>
                <?= $form->field($model, 'confirmPassword')->passwordInput(['placeholder'=>'Confirm Password'])->label(false) ?>
                <div class="col-lg-6">
                    <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                        'template' => '<div class="row"><div class="col-lg-6">{image}</div><div class="col-lg-6">{input}</div></div>',
                    ])->label(false)?>
                </div>
                <div class="form-group">
                    <?= Html::submitButton('Submit', ['class' => 'submit-button', 'name' => 'contact-button']) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
    <div class="con-footer">
        <p>Localtion:ROOM 1502(A) EASY COMMERCIAL BUILDING,253-261 HENNESSY ROAD,WANCHAI,HONGKONG</p>
        <p>Eamin: <strong>service@superads.cn</strong></p>
        <p>Phone:00052-30697751</p>
    </div>
<?php
$this->registerJsFile(
    '@web/new/js/signup.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>