<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model backend\models\FinanceAddCost */

$this->title = 'Create Finance Adjust Revenue';
$this->params['breadcrumbs'][] = ['label' => 'Finance Add Costs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin([
    'id' => 'adjust-cost-form',
//    'enableAjaxValidation' => true,
//    'validationUrl' => '/finance-add-cost/validate',
]); ?>
<?= $form->field($model, 'adjust_revenue')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'adjust_note')->textarea(['rows' => 6]) ?>
<?= $form->field($model, 'bill_id')->hiddenInput()->label(false) ?>

<div class="form-group">
    <?= Html::submitButton('Add', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
