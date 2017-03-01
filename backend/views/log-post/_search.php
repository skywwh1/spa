<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LogPostSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-post-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'click_uuid') ?>

    <?= $form->field($model, 'click_id') ?>

    <?= $form->field($model, 'channel_id') ?>

    <?= $form->field($model, 'campaign_id') ?>

    <?php // echo $form->field($model, 'pay_out') ?>

    <?php // echo $form->field($model, 'discount') ?>

    <?php // echo $form->field($model, 'daily_cap') ?>

    <?php // echo $form->field($model, 'post_link') ?>

    <?php // echo $form->field($model, 'post_time') ?>

    <?php // echo $form->field($model, 'post_status') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
