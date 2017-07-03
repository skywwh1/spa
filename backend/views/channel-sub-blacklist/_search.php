<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ChannelSubBlacklistSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="channel-sub-blacklist-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'channel_id') ?>

    <?= $form->field($model, 'sub_channel') ?>

    <?= $form->field($model, 'geo') ?>

    <?= $form->field($model, 'os') ?>

    <?php // echo $form->field($model, 'category') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
