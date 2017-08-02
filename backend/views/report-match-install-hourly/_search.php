<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ReportMatchInstallHourlySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="report-match-install-hourly-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'campaign_id') ?>

    <?= $form->field($model, 'time') ?>

    <?= $form->field($model, 'advertiser_id') ?>

    <?= $form->field($model, 'installs') ?>

    <?= $form->field($model, 'installs_in') ?>

    <?php // echo $form->field($model, 'revenue') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
