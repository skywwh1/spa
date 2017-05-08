<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ChannelBlackSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="channel-black-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'advertiser') ?>

    <?= $form->field($model, 'channel_id') ?>

    <?= $form->field($model, 'campaign_id') ?>

    <?= $form->field($model, 'geo') ?>

    <?php // echo $form->field($model, 'os') ?>

    <?php // echo $form->field($model, 'action') ?>

    <?php // echo $form->field($model, 'note') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
