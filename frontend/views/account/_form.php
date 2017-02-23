<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\PaymentForm */
/* @var $form ActiveForm */
?>
<h4>Update Payment</h4>
<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-10">
                        <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'payment_way')->checkboxList(ModelsUtil::payment_way) ?>

                        <?= $form->field($model, 'beneficiary_name')->textInput() ?>

                        <?= $form->field($model, 'bank_country')->textInput(['maxlength' => true]) ?>


                        <?= $form->field($model, 'bank_name')->textInput(['maxlength' => true]) ?>


                        <?= $form->field($model, 'bank_address')->textInput(['maxlength' => true]) ?>


                        <?= $form->field($model, 'swift')->textInput(['maxlength' => true]) ?>


                        <?= $form->field($model, 'account_nu_iban')->textInput(['maxlength' => true]) ?>

                        <div class="form-group">
                            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
                        </div>
                        <?php ActiveForm::end(); ?>
                    </div>
                    <!-- /.col-lg-6 (nested) -->
                </div>
                <!-- /.row (nested) -->
            </div>
            <!-- /.panel-body -->
        </div>
        <!-- /.panel -->
    </div>
    <!-- /.col-lg-12 -->
</div>



