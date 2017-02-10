<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ApiCampaignSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="api-campaign-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'adv_id') ?>

    <?= $form->field($model, 'adv_update_time') ?>

    <?= $form->field($model, 'effective_time') ?>

    <?= $form->field($model, 'campaign_id') ?>

    <?= $form->field($model, 'campaign_uuid') ?>

    <?php // echo $form->field($model, 'campaign_name') ?>

    <?php // echo $form->field($model, 'pricing_mode') ?>

    <?php // echo $form->field($model, 'promote_start') ?>

    <?php // echo $form->field($model, 'end_time') ?>

    <?php // echo $form->field($model, 'platform') ?>

    <?php // echo $form->field($model, 'daily_cap') ?>

    <?php // echo $form->field($model, 'adv_price') ?>

    <?php // echo $form->field($model, 'payout_currency') ?>

    <?php // echo $form->field($model, 'daily_budget') ?>

    <?php // echo $form->field($model, 'target_geo') ?>

    <?php // echo $form->field($model, 'adv_link') ?>

    <?php // echo $form->field($model, 'traffice_source') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'preview_link') ?>

    <?php // echo $form->field($model, 'icon') ?>

    <?php // echo $form->field($model, 'package_name') ?>

    <?php // echo $form->field($model, 'app_name') ?>

    <?php // echo $form->field($model, 'app_size') ?>

    <?php // echo $form->field($model, 'category') ?>

    <?php // echo $form->field($model, 'version') ?>

    <?php // echo $form->field($model, 'app_rate') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'creative_link') ?>

    <?php // echo $form->field($model, 'creative_type') ?>

    <?php // echo $form->field($model, 'creative_description') ?>

    <?php // echo $form->field($model, 'carriers') ?>

    <?php // echo $form->field($model, 'conversion_flow') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
