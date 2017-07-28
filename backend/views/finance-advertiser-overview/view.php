<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model backend\models\FinanceAdvertiserBillTerm */
/* @var $form yii\widgets\ActiveForm */

$this->title = $model->bill_id;
$this->params['breadcrumbs'][] = ['label' => 'Delivers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="deliver-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class='row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'invoice_id')->textInput() ?>
        </div>
        <div class='col-lg-4'>
            <?= $form->field($model, 'adv')->textInput() ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-2'>
            <?= $form->field($model, 'report_cost')->textInput() ?>
        </div>
        <div class='col-lg-2'>
            <?= $form->field($model, 'revenue')->label('revenue')->textInput() ?>
        </div>
        <div class='col-lg-2'>
            <?= $form->field($model, 'add_cost')->textInput() ?>
        </div>
        <div class='col-lg-2'>
            <?= $form->field($model, 'add_revenue')->textInput() ?>
        </div>
        <div class='col-lg-2'>
            <?= $form->field($model, 'pending_cost')->label('PendingCost')->textInput() ?>
        </div>
        <div class='col-lg-2'>
            <?= $form->field($model, 'pending')->textInput() ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-2'>
            <?= $form->field($model, 'deduction_cost')->label('DeductCost')->textInput() ?>
        </div>
        <div class='col-lg-2'>
            <?= $form->field($model, 'deduction')->label('DeductRevenue')->textInput() ?>
        </div>
        <div class='col-lg-2'>
            <?= $form->field($model, 'cha_payable')->textInput() ?>
        </div>
        <div class='col-lg-2'>
            <?= $form->field($model, 'receivable')->textInput() ?>
        </div>
        <div class='col-lg-2'>
            <?= $form->field($model, 'cha_paid')->textInput() ?>
        </div>
        <div class='col-lg-2'>
            <?= $form->field($model, 'final_revenue')->textInput() ?>
        </div>
    </div>

    <div class='form-group row'>

        <div class='col-lg-4'>
            <?= $form->field($model, 'actual_margin')->textInput() ?>
        </div>
        <div class='col-lg-4'>
            <?= $form->field($model, 'cash_flow')->textInput() ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>