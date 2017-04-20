<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model backend\models\FinanceAdvertiserPrepayment */

$this->title = 'Create Finance Advertiser Prepayment';
$this->params['breadcrumbs'][] = ['label' => 'Finance Advertiser Prepayments', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin([
    'id' => 'apply-prepayment-form',
    'enableAjaxValidation' => true,
    'validationUrl' => '/finance-advertiser-prepayment/validate',
]); ?>


<?= $form->field($model, 'prepayment')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'advertiser_bill_id')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>

<div class="form-group">
    <?= Html::submitButton('Apply', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
