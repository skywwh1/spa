<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LogPost */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-lg-6">
        <div class="box box-info">
            <div class="box-body">
                <div class="log-post-form">

                    <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'click_uuid')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'click_id')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'channel_id')->textInput() ?>
    <?= $form->field($model, 'campaign_id')->textInput() ?>
    <?= $form->field($model, 'pay_out')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'discount')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'daily_cap')->textInput() ?>
    <?= $form->field($model, 'post_link')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'post_time')->textInput() ?>
    <?= $form->field($model, 'post_status')->textInput() ?>
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