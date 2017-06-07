<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model backend\models\FinanceAddRevenue */

$this->title = 'Create Finance Add Revenue';
$this->params['breadcrumbs'][] = ['label' => 'Finance Add Revenues', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<?php $form = ActiveForm::begin([
    'id' => 'add-cost-form',
    'enableAjaxValidation' => true,
    'validationUrl' => '/finance-add-revenue/validate',
]); ?>

<?= $form->field($model, 'revenue')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'cost')->textInput(['maxlength' => true]) ?>
<?= $form->field($model, 'advertiser_bill_id')->hiddenInput()->label(false) ?>
<?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>
    <div class="form-group">
        <?= Html::submitButton('Add', ['class' => 'btn btn-success']) ?>
    </div>

<?php ActiveForm::end(); ?>