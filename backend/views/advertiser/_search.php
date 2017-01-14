<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\AdvertiserSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="advertiser-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'username') ?>

    <?= $form->field($model, 'firstname') ?>

    <?= $form->field($model, 'lastname') ?>

    <?= $form->field($model, 'settlement_type') ?>

    <?php // echo $form->field($model, 'pm') ?>

    <?php // echo $form->field($model, 'bd') ?>

    <?php // echo $form->field($model, 'system') ?>

    <?php // echo $form->field($model, 'status') ?>

    <?php // echo $form->field($model, 'contacts') ?>

    <?php // echo $form->field($model, 'total_revenue') ?>

    <?php // echo $form->field($model, 'receivable') ?>

    <?php // echo $form->field($model, 'received') ?>

    <?php // echo $form->field($model, 'pricing_mode') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'auth_key') ?>

    <?php // echo $form->field($model, 'password_hash') ?>

    <?php // echo $form->field($model, 'password_reset_token') ?>

    <?php // echo $form->field($model, 'created_time') ?>

    <?php // echo $form->field($model, 'updated_time') ?>

    <?php // echo $form->field($model, 'post_parameter') ?>

    <?php // echo $form->field($model, 'email') ?>

    <?php // echo $form->field($model, 'cc_email') ?>

    <?php // echo $form->field($model, 'company') ?>

    <?php // echo $form->field($model, 'country') ?>

    <?php // echo $form->field($model, 'city') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'phone1') ?>

    <?php // echo $form->field($model, 'phone2') ?>

    <?php // echo $form->field($model, 'weixin') ?>

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

    <?php // echo $form->field($model, 'note') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
