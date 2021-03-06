<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\FinanceSubRevenue */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-lg-6">
        <div class="box box-info">
            <div class="box-body">
                <div class="finance-sub-revenue-form">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'advertiser_bill_id')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'advertiser_id')->textInput() ?>
                    <?= $form->field($model, 'timezone')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'revenue')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'om')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>
                    <?= $form->field($model, 'create_time')->textInput() ?>
                    <?= $form->field($model, 'update_time')->textInput() ?>
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