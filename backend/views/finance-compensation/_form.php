<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\FinanceCompensation */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-lg-6">
        <div class="box box-info">
            <div class="box-body">
                <div class="finance-compensation-form">

                    <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'deduction_id')->textInput() ?>
    <?= $form->field($model, 'compensation')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'billable_cost')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'billable_revenue')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'billable_margin')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'final_margin')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'status')->textInput() ?>
    <?= $form->field($model, 'editor')->textInput() ?>
    <?= $form->field($model, 'creator')->textInput() ?>
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