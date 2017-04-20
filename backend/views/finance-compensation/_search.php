<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\FinanceCompensationSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="finance-compensation-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'deduction_id') ?>

    <?= $form->field($model, 'compensation') ?>

    <?= $form->field($model, 'billable_cost') ?>

    <?= $form->field($model, 'billable_revenue') ?>

    <?= $form->field($model, 'billable_margin') ?>

    <?php // echo $form->field($model, 'final_margin') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'editor') ?>

    <?php // echo $form->field($model, 'creator') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
