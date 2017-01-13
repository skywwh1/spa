<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\CampaignSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="campaign-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'advertiser') ?>

    <?= $form->field($model, 'campaign_name') ?>

    <?= $form->field($model, 'tag') ?>

    <?= $form->field($model, 'campaign_uuid') ?>

    <?php // echo $form->field($model, 'pricing_mode') ?>

    <?php // echo $form->field($model, 'promote_start') ?>

    <?php // echo $form->field($model, 'promote_end') ?>

    <?php // echo $form->field($model, 'end_time') ?>

    <?php // echo $form->field($model, 'device') ?>

    <?php // echo $form->field($model, 'platform') ?>

    <?php // echo $form->field($model, 'daily_cap') ?>

    <?php // echo $form->field($model, 'open_cap') ?>

    <?php // echo $form->field($model, 'adv_price') ?>

    <?php // echo $form->field($model, 'now_payout') ?>

    <?php // echo $form->field($model, 'target_geo') ?>

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

    <?php // echo $form->field($model, 'recommended') ?>

    <?php // echo $form->field($model, 'indirect') ?>

    <?php // echo $form->field($model, 'cap') ?>

    <?php // echo $form->field($model, 'cvr') ?>

    <?php // echo $form->field($model, 'epc') ?>

    <?php // echo $form->field($model, 'pm') ?>

    <?php // echo $form->field($model, 'bd') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'open_type') ?>

    <?php // echo $form->field($model, 'subid_status') ?>

    <?php // echo $form->field($model, 'track_way') ?>

    <?php // echo $form->field($model, 'third_party') ?>

    <?php // echo $form->field($model, 'track_link_domain') ?>

    <?php // echo $form->field($model, 'adv_link') ?>

    <?php // echo $form->field($model, 'ip_blacklist') ?>

    <?php // echo $form->field($model, 'creator') ?>

    <?php // echo $form->field($model, 'create_time') ?>

    <?php // echo $form->field($model, 'update_time') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
