<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LogEventSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-event-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'click_uuid') ?>

    <?= $form->field($model, 'auth_token') ?>

    <?= $form->field($model, 'channel_id') ?>

    <?= $form->field($model, 'event_name') ?>

    <?php // echo $form->field($model, 'event_value') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'ip') ?>

    <?php // echo $form->field($model, 'ip_long') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
