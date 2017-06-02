<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model backend\models\FinanceSubCost */

$this->title = 'Create Finance Sub Cost';
$this->params['breadcrumbs'][] = ['label' => 'Finance Sub Costs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin([
    'id' => 'sub-cost-form',
    'enableAjaxValidation' => true,
    'validationUrl' => '/finance-sub-cost/validate',
]); ?>

<?= $form->field($model, 'cost')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>
<?= $form->field($model, 'channel_bill_id')->hiddenInput()->label(false) ?>

<div class="form-group">
    <?= Html::submitButton('Sub', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
