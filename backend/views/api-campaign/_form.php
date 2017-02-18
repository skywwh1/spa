<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ApiCampaign */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-lg-6">
        <div class="box box-info">
            <div class="box-body">
                <div class="api-campaign-form">

                    <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'adv_id')->textInput() ?>
    <?= $form->field($model, 'adv_update_time')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'effective_time')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'campaign_id')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'campaign_uuid')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'campaign_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'pricing_mode')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'promote_start')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'end_time')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'platform')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'daily_cap')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'adv_price')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'daily_budget')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'target_geo')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'adv_link')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'traffic_source')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>
    <?= $form->field($model, 'preview_link')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'icon')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'package_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'app_name')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'app_size')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'category')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'version')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'app_rate')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'description')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'creative_link')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'creative_type')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'creative_description')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'carriers')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'conversion_flow')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'status')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'create_time')->textInput() ?>
    <?= $form->field($model, 'update_time')->textInput() ?>
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