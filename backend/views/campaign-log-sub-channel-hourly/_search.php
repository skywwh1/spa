<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ReportSubChannelSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="campaign-log-sub-channel-hourly-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'campaign_id') ?>

    <?= $form->field($model, 'channel_id') ?>

    <?= $form->field($model, 'sub_channel') ?>

    <?= $form->field($model, 'time') ?>

    <?= $form->field($model, 'time_format') ?>

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

    <?php // echo $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
