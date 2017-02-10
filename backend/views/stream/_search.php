<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\StreamSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="stream-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'click_uuid') ?>

    <?= $form->field($model, 'click_id') ?>

    <?= $form->field($model, 'cp_uid') ?>

    <?= $form->field($model, 'ch_id') ?>

    <?php // echo $form->field($model, 'pl') ?>

    <?php // echo $form->field($model, 'tx_id') ?>

    <?php // echo $form->field($model, 'all_parameters') ?>

    <?php // echo $form->field($model, 'ip') ?>

    <?php // echo $form->field($model, 'redirect') ?>

    <?php // echo $form->field($model, 'browser') ?>

    <?php // echo $form->field($model, 'browser_type') ?>

    <?php // echo $form->field($model, 'post_link') ?>

    <?php // echo $form->field($model, 'post_status') ?>

    <?php // echo $form->field($model, 'post_time') ?>

    <?php // echo $form->field($model, 'is_count') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
