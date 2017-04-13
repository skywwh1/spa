<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\FinanceAdvertiserBillTermSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="finance-advertiser-bill-month-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'invoice_id') ?>

    <?= $form->field($model, 'adv_id') ?>

    <?= $form->field($model, 'time_zone') ?>

    <?= $form->field($model, 'start_time') ?>

    <?= $form->field($model, 'end_time') ?>

    <?php // echo $form->field($model, 'clicks') ?>

    <?php // echo $form->field($model, 'unique_clicks') ?>

    <?php // echo $form->field($model, 'installs') ?>

    <?php // echo $form->field($model, 'match_installs') ?>

    <?php // echo $form->field($model, 'redirect_installs') ?>

    <?php // echo $form->field($model, 'redirect_match_installs') ?>

    <?php // echo $form->field($model, 'pay_out') ?>

    <?php // echo $form->field($model, 'adv_price') ?>

    <?php // echo $form->field($model, 'daily_cap') ?>

    <?php // echo $form->field($model, 'cap') ?>

    <?php // echo $form->field($model, 'cost') ?>

    <?php // echo $form->field($model, 'redirect_cost') ?>

    <?php // echo $form->field($model, 'revenue') ?>

    <?php // echo $form->field($model, 'redirect_revenue') ?>

    <?php // echo $form->field($model, 'receivable') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
