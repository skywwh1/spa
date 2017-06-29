<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\User */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-lg-6">
        <div class="box box-info">
            <div class="box-body">
                <div class="user-form">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'phone1')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'weixin')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'qq')->textInput() ?>
                    <?= $form->field($model, 'skype')->textInput(['maxlength' => true]) ?>
                    <div class="form-group">
                        <?= Html::submitButton('submit',['class' => 'btn btn-primary'],['user/profile']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>