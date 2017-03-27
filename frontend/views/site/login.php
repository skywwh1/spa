<?php

/* @var $this yii\web\View */

use common\models\RegionsDomain;
use yii\captcha\Captcha;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'About';
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="tact-con">
        <img src="<?= Yii::getAlias('@web/new/img/signup-bg.png') ?>" alt=""/>
        <div class="sign-middle">
            <h1>Login</h1>
            <div class="sign-table">
                <?php $form = ActiveForm::begin(); ?>
                <?= $form->field($model, 'username')->textInput(['placeholder'=>'Username'])->label(false) ?>
                <?= $form->field($model, 'password')->passwordInput(['placeholder'=>'Password'])->label(false) ?>
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
    '@web/new/js/login.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>