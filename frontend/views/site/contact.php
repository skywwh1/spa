<?php

/* @var $this yii\web\View */

use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="tact-con">
        <img src="<?= Yii::getAlias('@web/new/img/contact-bg.png') ?>" alt=""/>
        <div class="tact-left">
            <h1><strong>C</strong>ontact <strong>U</strong>s</h1>
            <div class="p">
                <p>we are dedicate to provide as much traffic you need! </p>
                <p>Contact us ! Let us help you maximize your product or website!</p>
            </div>
        </div>
        <div class="tact-right">
            <div class="tact-table">
                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>
                <?= $form->field($model, 'name')->textInput(['placeholder'=>'Name'])->label(false) ?>
                <?= $form->field($model, 'email')->textInput(['placeholder'=>'Email'])->label(false)?>

                <?= $form->field($model, 'subject')->textInput(['placeholder'=>'Subject'])->label(false) ?>

                <?= $form->field($model, 'body')->textarea(['rows' => 6,'placeholder'=>'Body'])->label(false) ?>

                <?= $form->field($model, 'verifyCode')->widget(Captcha::className(), [
                    'template' => '<div class="row"><div class="col-lg-3">{image}</div><div class="col-lg-3">{input}</div></div>',
                ])->label(false) ?>

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
    '@web/new/js/contact.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>