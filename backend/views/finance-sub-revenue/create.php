<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model backend\models\FinanceSubRevenue */

$this->title = 'Create Finance Sub Revenue';
$this->params['breadcrumbs'][] = ['label' => 'Finance Sub Revenues', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin([
    'id' => 'sub-cost-form',
    'enableAjaxValidation' => true,
    'validationUrl' => '/finance-sub-revenue/validate',
]); ?>

<?= $form->field($model, 'revenue')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'advertiser_bill_id')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>
    <div class="form-group">
        <?= Html::submitButton('Sub', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>