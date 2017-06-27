<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ProfileForm */
/* @var $form ActiveForm */
?>
<h4>Update Profile</h4>
<div class="row">
    <div class="col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <div class="row">
                    <div class="col-lg-10">
                        <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'phone1')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'skype')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                        <?= $form->field($model, 'company_address')->textInput(['maxlength' => true]) ?>

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



