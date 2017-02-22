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
                    <?= $form->field($model, 'password_hash')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'type')->textInput(['value'=>9]) ?>
                    <?= $form->field($model, 'status')->textInput(['value'=>1]) ?>
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'phone1')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'phone2')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'weixin')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'qq')->textInput() ?>
                    <?= $form->field($model, 'skype')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'alipay')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'city')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'lang')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'timezone')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'firstaccess')->textInput() ?>
                    <?= $form->field($model, 'lastaccess')->textInput() ?>
                    <?= $form->field($model, 'picture')->textInput() ?>
                    <?= $form->field($model, 'suspended')->textInput(['value'=>0]) ?>
                    <?= $form->field($model, 'deleted')->textInput(['value'=>0]) ?>
                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord
                            ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn
                        btn-success' :
                            'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>