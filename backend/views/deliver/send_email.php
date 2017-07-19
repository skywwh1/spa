<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\redactor\widgets\Redactor;
/* @var $this yii\web\View */
/* @var $model common\models\EmailContent */

?>
<h3>Send Email</h3>
<?php $form = ActiveForm::begin([
    'id' => $model->formName(),
//    'enableAjaxValidation' => true,
    // 'validationUrl' => \yii\helpers\Url::toRoute('campaign-sts-update/validate'),
]); ?>

<?= $form->field($model, 'channel_id')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'campaign_id')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'content')->widget(Redactor::className(), [
    'clientOptions' => [
        'imageManagerJson' => ['/redactor/upload/image-json'],
        'imageUpload' => ['/redactor/upload/image'],
        'fileUpload' => ['/redactor/upload/file'],
        'lang' => 'zh_cn',
        'plugins' => ['table','imagemanager','imagemanager','filemanager']
    ]
])?>
<div class="form-group">
    <?= Html::submitButton('Send', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>