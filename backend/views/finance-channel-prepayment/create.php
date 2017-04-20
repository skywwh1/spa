<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model backend\models\FinanceChannelPrepayment */

$this->title = 'Create Finance Apply Prepayment';
$this->params['breadcrumbs'][] = ['label' => 'Finance Apply Prepayments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin([
    'id' => 'apply-prepayment-form',
    'enableAjaxValidation' => true,
    'validationUrl' => '/finance-channel-prepayment/validate',
]); ?>

<?= $form->field($model, 'prepayment')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'channel_bill_id')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>
    <div class="form-group">
        <?= Html::submitButton('Apply', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>