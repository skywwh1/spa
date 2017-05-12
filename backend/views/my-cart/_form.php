<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MyCart */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-lg-6">
        <div class="box box-info">
            <div class="box-body">
                <div class="my-cart-form">

                    <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'id')->textInput() ?>
                        <?= $form->field($model, 'campaign_id')->textInput() ?>
                        <?= $form->field($model, 'campaign_name')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'target_geo')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'platform')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'payout')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'daily_cap')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'traffic_source')->textInput(['maxlength' => true]) ?>
                        <?= $form->field($model, 'tag')->textInput() ?>
                        <?= $form->field($model, 'direct')->textInput() ?>
                        <?= $form->field($model, 'advertiser')->textInput() ?>
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