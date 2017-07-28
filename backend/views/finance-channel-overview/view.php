<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\FinanceChannelBillTerm */
/* @var $form yii\widgets\ActiveForm */
$this->title = $model->bill_id;
$this->params['breadcrumbs'][] = ['label' => 'Delivers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="deliver-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class='row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'bill_id')->textInput() ?>
        </div>
        <div class='col-lg-4'>
            <?= $form->field($model, 'channel')->textInput() ?>
        </div>
        <div class='col-lg-4'>
            <?= $form->field($model, 'period')->textInput() ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-2'>
            <?= $form->field($model, 'cost')->textInput() ?>
        </div>
        <div class='col-lg-2'>
            <?= $form->field($model, 'report_revenue')->label('revenue')->textInput() ?>
        </div>
        <div class='col-lg-2'>
            <?= $form->field($model, 'add_cost')->textInput() ?>
        </div>
        <div class='col-lg-2'>
            <?= $form->field($model, 'add_revenue')->textInput() ?>
        </div>
        <div class='col-lg-2'>
            <?= $form->field($model, 'pending')->label('PendingCost')->textInput() ?>
        </div>
        <div class='col-lg-2'>
            <?= $form->field($model, 'pending_revenue')->textInput() ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-2'>
            <?= $form->field($model, 'deduction')->label('DeductCost')->textInput() ?>
        </div>
        <div class='col-lg-2'>
            <?= $form->field($model, 'deduction_revenue')->label('DeductRevenue')->textInput() ?>
        </div>
        <div class='col-lg-4'>
            <?= $form->field($model, 'compensation')->textInput() ?>
        </div>
        <div class='col-lg-2'>
            <?= $form->field($model, 'payable')->textInput() ?>
        </div>
        <div class='col-lg-2'>
            <?= $form->field($model, 'adv_receivable')->textInput() ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-2'>
            <?= $form->field($model, 'final_cost')->textInput() ?>
        </div>
        <div class='col-lg-2'>
            <?= $form->field($model, 'adv_received')->textInput() ?>
        </div>
        <div class='col-lg-4'>
            <?= $form->field($model, 'actual_margin')->textInput() ?>
        </div>
        <div class='col-lg-4'>
            <?= $form->field($model, 'cash_flow')->textInput() ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
