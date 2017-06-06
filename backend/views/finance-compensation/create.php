<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model backend\models\FinanceCompensation */

$this->title = 'Create Finance Compensation';
$this->params['breadcrumbs'][] = ['label' => 'Finance Compensations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="finance-compensation-create"></div>
    <div class="row">
        <div class="col-lg-12">
            <?php $form = ActiveForm::begin([
                'enableAjaxValidation' => true,
                'validationUrl' => '/finance-compensation/validate',
                'id' => 'compensation-form',
            ]); ?>

            <?= $form->field($model, 'deduction_id')->textInput(['maxlength' => true, 'readonly' => 'readonly']) ?>
            <?= $form->field($model, 'compensation')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'note')->textarea(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton('Apply', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
<?php
$this->registerJsFile('@web/js/finance-compensation.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]);
?>