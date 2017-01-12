<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\S2sSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="s2s-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'campaign_id') ?>

    <?= $form->field($model, 'channel_id') ?>

    <?= $form->field($model, 'pay_out') ?>

    <?= $form->field($model, 'daily_cap') ?>

    <?= $form->field($model, 'discount') ?>

    <?php // echo $form->field($model, 'is_run') ?>

    <?php // echo $form->field($model, 'creator') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'note') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
