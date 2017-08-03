<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ReportMatchInstallHourly */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-lg-6">
        <div class="box box-info">
            <div class="box-body">
                <div class="report-match-install-hourly-form">

                    <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'campaign_id')->textInput() ?>
    <?= $form->field($model, 'time')->textInput() ?>
    <?= $form->field($model, 'advertiser_id')->textInput() ?>
    <?= $form->field($model, 'installs')->textInput() ?>
    <?= $form->field($model, 'installs_in')->textInput() ?>
    <?= $form->field($model, 'revenue')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'update_time')->textInput() ?>
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