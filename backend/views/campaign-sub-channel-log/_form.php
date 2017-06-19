<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CampaignSubChannelLog */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-lg-6">
        <div class="box box-info">
            <div class="box-body">
                <div class="campaign-sub-channel-log-form">

                    <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'campaign_id')->textInput() ?>
    <?= $form->field($model, 'channel_id')->textInput() ?>
    <?= $form->field($model, 'sub_channel')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'is_send')->textInput() ?>
    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'is_effected')->textInput() ?>
    <?= $form->field($model, 'effect_time')->textInput() ?>
    <?= $form->field($model, 'create_time')->textInput() ?>
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