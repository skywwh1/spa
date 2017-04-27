<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LogEvent */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-lg-6">
        <div class="box box-info">
            <div class="box-body">
                <div class="log-event-form">

                    <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'click_uuid')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'auth_token')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'channel_id')->textInput() ?>
    <?= $form->field($model, 'event_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'event_value')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'create_time')->textInput() ?>
    <?= $form->field($model, 'update_time')->textInput() ?>
    <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'ip_long')->textInput() ?>
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