<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CampaignSubChannelLogRedirect */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="redirect-log-form">
    <h3>Redirect Option</h3>
    <?php $form = ActiveForm::begin([
        'id' => 'redirect-form',
        'enableAjaxValidation' => true,
        'validationUrl' => '/campaign-sub-channel-log-redirect/validate',
    ]); ?>

    <?= $form->field($model, 'campaign_id')->textInput(['readonly' => true]) ?>
    <?= $form->field($model, 'channel_id')->textInput(['readonly' => true]) ?>
    <?= $form->field($model, 'campaign_id_new')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'sub_channel')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'discount')->textInput(['maxlength' => true]) ?>
    <?= $form->field($model, 'status')->hiddenInput(['value' => isset($model->campaign_id_new) ? 0 : 1])->label(false) ?>
    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' =>  'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php
$this->registerJsFile('@web/js/redirect.js',
['depends' => [\yii\web\JqueryAsset::className()]]);
?>