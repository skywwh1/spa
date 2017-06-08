<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model backend\models\FinanceAddCost */

$this->title = 'Create Finance Add Cost';
$this->params['breadcrumbs'][] = ['label' => 'Finance Add Costs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin([
    'id' => 'add-cost-form',
    'enableAjaxValidation' => true,
    'validationUrl' => '/finance-add-cost/validate',
]); ?>

<?= $form->field($model, 'cost')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'revenue')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>
<?= $form->field($model, 'channel_bill_id')->hiddenInput()->label(false) ?>

<div class="form-group">
    <?= Html::submitButton('Add', ['class' => 'btn btn-success']) ?>
</div>

<?php ActiveForm::end(); ?>
