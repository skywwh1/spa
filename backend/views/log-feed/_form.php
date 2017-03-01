<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LogFeed */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-lg-6">
        <div class="box box-info">
            <div class="box-body">
                <div class="log-feed-form">

                    <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'auth_token')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'click_uuid')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'click_id')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'channel_id')->textInput() ?>
    <?= $form->field($model, 'campaign_id')->textInput() ?>
    <?= $form->field($model, 'ch_subid')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'all_parameters')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'ip')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'adv_price')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'feed_time')->textInput() ?>
    <?= $form->field($model, 'is_post')->textInput() ?>
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