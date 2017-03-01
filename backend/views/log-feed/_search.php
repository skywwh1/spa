<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\LogFeedSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="log-feed-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'auth_token') ?>

    <?= $form->field($model, 'click_uuid') ?>

    <?= $form->field($model, 'click_id') ?>

    <?= $form->field($model, 'channel_id') ?>

    <?php // echo $form->field($model, 'campaign_id') ?>

    <?php // echo $form->field($model, 'ch_subid') ?>

    <?php // echo $form->field($model, 'all_parameters') ?>

    <?php // echo $form->field($model, 'ip') ?>

    <?php // echo $form->field($model, 'adv_price') ?>

    <?php // echo $form->field($model, 'feed_time') ?>

    <?php // echo $form->field($model, 'is_post') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
