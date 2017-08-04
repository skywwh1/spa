<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\System */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-lg-6">
        <div class="box box-info">
            <div class="box-body">
                <div class="system-form">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'post_parameter')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'mark')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'note')->textInput(['maxlength' => true]) ?>
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