<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\FinancePendingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="finance-pending-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'campaign_id') ?>

    <?= $form->field($model, 'channel_id') ?>

    <?= $form->field($model, 'start_date') ?>

    <?= $form->field($model, 'end_date') ?>

    <?php // echo $form->field($model, 'install') ?>

    <?php // echo $form->field($model, 'cost') ?>

    <?php // echo $form->field($model, 'revenue') ?>

    <?php // echo $form->field($model, 'margin') ?>

    <?php // echo $form->field($model, 'adv') ?>

    <?php // echo $form->field($model, 'pm') ?>

    <?php // echo $form->field($model, 'bd') ?>

    <?php // echo $form->field($model, 'om') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
