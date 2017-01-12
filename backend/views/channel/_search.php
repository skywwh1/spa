<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ChannelSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="channel-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'team') ?>

    <?= $form->field($model, 'firstname') ?>

    <?= $form->field($model, 'lastname') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'auth_key') ?>

    <?php // echo $form->field($model, 'password_hash') ?>

    <?php // echo $form->field($model, 'password_reset_token') ?>

    <?php // echo $form->field($model, 'settlement_type') ?>

    <?php // echo $form->field($model, 'om') ?>

    <?php // echo $form->field($model, 'main_channel') ?>

    <?php // echo $form->field($model, 'account_name') ?>

    <?php // echo $form->field($model, 'branch_name') ?>

    <?php // echo $form->field($model, 'card_number') ?>

    <?php // echo $form->field($model, 'contacts') ?>

    <?php // echo $form->field($model, 'created_time') ?>

    <?php // echo $form->field($model, 'updated_time') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'country') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'company') ?>

    <?php // echo $form->field($model, 'phone1') ?>

    <?php // echo $form->field($model, 'phone2') ?>

    <?php // echo $form->field($model, 'wechat') ?>

    <?php // echo $form->field($model, 'qq') ?>

    <?php // echo $form->field($model, 'skype') ?>

    <?php // echo $form->field($model, 'alipay') ?>

    <?php // echo $form->field($model, 'lang') ?>

    <?php // echo $form->field($model, 'timezone') ?>

    <?php // echo $form->field($model, 'firstaccess') ?>

    <?php // echo $form->field($model, 'lastaccess') ?>

    <?php // echo $form->field($model, 'picture') ?>

    <?php // echo $form->field($model, 'confirmed') ?>

    <?php // echo $form->field($model, 'suspended') ?>

    <?php // echo $form->field($model, 'deleted') ?>

    <?php // echo $form->field($model, 'bd') ?>

    <?php // echo $form->field($model, 'system') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'cc_email') ?>

    <?php // echo $form->field($model, 'traffic_source') ?>

    <?php // echo $form->field($model, 'pricing_mode') ?>

    <?php // echo $form->field($model, 'note') ?>

    <?php // echo $form->field($model, 'app_id') ?>

    <?php // echo $form->field($model, 'post_back') ?>

    <?php // echo $form->field($model, 'click_pram_name') ?>

    <?php // echo $form->field($model, 'click_pram_length') ?>

    <?php // echo $form->field($model, 'total_revenue') ?>

    <?php // echo $form->field($model, 'need_pay') ?>

    <?php // echo $form->field($model, 'already_pay') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
