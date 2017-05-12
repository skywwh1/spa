<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\MyCartSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="my-cart-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'campaign_id') ?>

    <?= $form->field($model, 'campaign_name') ?>

    <?= $form->field($model, 'target_geo') ?>

    <?= $form->field($model, 'platform') ?>

    <?php // echo $form->field($model, 'payout_currency') ?>

    <?php // echo $form->field($model, 'daily_cap') ?>

    <?php // echo $form->field($model, 'traffic_source') ?>

    <?php // echo $form->field($model, 'tag') ?>

    <?php // echo $form->field($model, 'direct') ?>

    <?php // echo $form->field($model, 'advertiser') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
