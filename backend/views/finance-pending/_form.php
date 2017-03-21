<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\FinancePending */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-lg-6">
        <div class="box box-info">
            <div class="box-body">
                <div class="finance-pending-form">

                    <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'campaign_id')->textInput() ?>
    <?= $form->field($model, 'channel_id')->textInput() ?>
    <?= $form->field($model, 'start_date')->textInput() ?>
    <?= $form->field($model, 'end_date')->textInput() ?>
    <?= $form->field($model, 'install')->textInput() ?>
    <?= $form->field($model, 'cost')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'revenue')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'margin')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'adv')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'pm')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'bd')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'om')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'status')->textInput() ?>
    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'create_time')->textInput() ?>
    <?= $form->field($model, 'update_time')->textInput() ?>
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