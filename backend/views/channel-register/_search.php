<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ChannelRegisterSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="channel-register-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'channel_id') ?>

    <?= $form->field($model, 'vertical') ?>

    <?= $form->field($model, 'offer_type') ?>

    <?= $form->field($model, 'other_network') ?>

    <?php // echo $form->field($model, 'vertical_interested') ?>

    <?php // echo $form->field($model, 'special_offer') ?>

    <?php // echo $form->field($model, 'regions') ?>

    <?php // echo $form->field($model, 'traffic_type') ?>

    <?php // echo $form->field($model, 'best_time') ?>

    <?php // echo $form->field($model, 'time_zone') ?>

    <?php // echo $form->field($model, 'suggested_am') ?>

    <?php // echo $form->field($model, 'additional_notes') ?>

    <?php // echo $form->field($model, 'another_info') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
