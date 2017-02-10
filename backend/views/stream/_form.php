<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Stream */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-lg-6">
        <div class="box box-info">
            <div class="box-body">
                <div class="stream-form">

                    <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'click_uuid')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'click_id')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'cp_uid')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'ch_id')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'pl')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'tx_id')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'all_parameters')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'redirect')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'browser')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'browser_type')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'post_link')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'post_status')->textInput() ?>
    <?= $form->field($model, 'post_time')->textInput() ?>
    <?= $form->field($model, 'is_count')->textInput() ?>
    <?= $form->field($model, 'create_time')->textInput() ?>
                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord
                        ? 'Create'                        : 'Update', ['class' => $model->isNewRecord ? 'btn
                        btn-success' :
                        'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>