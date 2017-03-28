<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\RedirectLog */
/* @var $form yii\widgets\ActiveForm */
?>
    <div class="redirect-log-form">
    <h3>Redirect Option</h3>
        <?php $form = ActiveForm::begin([
            'id' => 'redirect-form',
            'enableAjaxValidation' => true,
            'validationUrl' => '/redirect-log/validate',
        ]); ?>

        <?= $form->field($model, 'campaign_id')->textInput(['readonly' => true]) ?>
        <?= $form->field($model, 'channel_id')->textInput(['readonly' => true]) ?>
        <?= $form->field($model, 'campaign_id_new')->textInput(['readonly' => isset($model->campaign_id_new) ? true : false]) ?>
        <?= $form->field($model, 'discount')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'status')->hiddenInput(['value' => isset($model->campaign_id_new) ? 0 : 1])->label(false) ?>
        <div class="form-group">
            <?= Html::submitButton(isset($model->campaign_id_new) ? 'Turn Off' : 'Turn On', ['class' => isset($model->campaign_id_new) ? 'btn btn-primary' : 'btn  btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
<?php
$this->registerJsFile('@web/js/redirect.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]);
?>