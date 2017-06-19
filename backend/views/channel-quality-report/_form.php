<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ChannelQualityReport */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-lg-6">
        <div class="box box-info">
            <div class="box-body">
                <div class="channel-quality-report-form">

                    <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'campaign_id')->textInput() ?>
                        <?= $form->field($model, 'channel_id')->textInput() ?>
                        <?= $form->field($model, 'sub_channel')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'time')->textInput() ?>
                        <?= $form->field($model, 'time_format')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'clicks')->textInput() ?>
                        <?= $form->field($model, 'unique_clicks')->textInput() ?>
                        <?= $form->field($model, 'installs')->textInput() ?>
                        <?= $form->field($model, 'match_installs')->textInput() ?>
                        <?= $form->field($model, 'redirect_installs')->textInput() ?>
                        <?= $form->field($model, 'redirect_match_installs')->textInput() ?>
                        <?= $form->field($model, 'pay_out')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'adv_price')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'daily_cap')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'cap')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'cost')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'redirect_cost')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'revenue')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'redirect_revenue')->textInput(['maxlength' => true]) ?>
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