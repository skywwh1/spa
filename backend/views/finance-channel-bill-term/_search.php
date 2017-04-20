<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\FinanceChannelBillTermSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="finance-channel-bill-term-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'bill_id') ?>

    <?= $form->field($model, 'invoice_id') ?>

    <?= $form->field($model, 'period') ?>

    <?= $form->field($model, 'channel_id') ?>

    <?= $form->field($model, 'time_zone') ?>

    <?php // echo $form->field($model, 'start_time') ?>

    <?php // echo $form->field($model, 'end_time') ?>

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

    <?php // echo $form->field($model, 'add_historic_cost') ?>

    <?php // echo $form->field($model, 'pending') ?>

    <?php // echo $form->field($model, 'deduction') ?>

    <?php // echo $form->field($model, 'compensation') ?>

    <?php // echo $form->field($model, 'add_cost') ?>

    <?php // echo $form->field($model, 'final_cost') ?>

    <?php // echo $form->field($model, 'actual_margin') ?>

    <?php // echo $form->field($model, 'paid_amount') ?>

    <?php // echo $form->field($model, 'payable') ?>

    <?php // echo $form->field($model, 'apply_prepayment') ?>

    <?php // echo $form->field($model, 'balance') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
