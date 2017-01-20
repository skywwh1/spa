<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\CampaignChannelLogSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="campaign-channel-log-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'campaign_id') ?>

    <?= $form->field($model, 'channel_id') ?>

    <?= $form->field($model, 'campaign_uuid') ?>

    <?= $form->field($model, 'adv_price') ?>

    <?= $form->field($model, 'pricing_mode') ?>

    <?php // echo $form->field($model, 'pay_out') ?>

    <?php // echo $form->field($model, 'daily_cap') ?>

    <?php // echo $form->field($model, 'actual_discount') ?>

    <?php // echo $form->field($model, 'discount') ?>

    <?php // echo $form->field($model, 'is_run') ?>

    <?php // echo $form->field($model, 'creator') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <?php // echo $form->field($model, 'track_url') ?>

    <?php // echo $form->field($model, 'click') ?>

    <?php // echo $form->field($model, 'unique_click') ?>

    <?php // echo $form->field($model, 'install') ?>

    <?php // echo $form->field($model, 'cvr') ?>

    <?php // echo $form->field($model, 'cost') ?>

    <?php // echo $form->field($model, 'match_install') ?>

    <?php // echo $form->field($model, 'match_cvr') ?>

    <?php // echo $form->field($model, 'revenue') ?>

    <?php // echo $form->field($model, 'def') ?>

    <?php // echo $form->field($model, 'deduction_percent') ?>

    <?php // echo $form->field($model, 'profit') ?>

    <?php // echo $form->field($model, 'margin') ?>

    <?php // echo $form->field($model, 'note') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
