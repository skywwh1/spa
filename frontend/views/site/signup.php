<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\Channel */
/* @var $form ActiveForm */
$this->title = 'Signup';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <p>Please fill out the following fields to signup:</p>
    <div class="row">
        <?php $form = ActiveForm::begin(); ?>
        <div class="row">
            <div class="col-lg-3">
                <?= $form->field($model, 'username') ?>
            </div>
            <div class="col-lg-3">
                <?= $form->field($model, 'company') ?>
            </div>
            <div class="col-lg-3">
                <?= $form->field($model, 'timezone') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <?= $form->field($model, 'email') ?>
            </div>
            <div class="col-lg-3">
                <?= $form->field($model, 'phone1') ?>
            </div>
            <div class="col-lg-3">
                <?= $form->field($model, 'skype') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-3">
                <?= $form->field($model, 'country') ?>
            </div>
            <div class="col-lg-6">
                <?= $form->field($model, 'address') ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-9">
                <?= $form->field($model, 'vertical') ?>
                <?= $form->field($model, 'offer_type') ?>
                <?= $form->field($model, 'other_network') ?>
                <?= $form->field($model, 'vertical_interested') ?>
                <?= $form->field($model, 'special_offer') ?>
                <?= $form->field($model, 'regions') ?>
                <?= $form->field($model, 'traffic_type') ?>
                <?= $form->field($model, 'best_time') ?>
                <?= $form->field($model, 'time_zone') ?>
                <?= $form->field($model, 'suggested_am') ?>
                <?= $form->field($model, 'additional_notes') ?>
                <?= $form->field($model, 'another_info') ?>
            </div>
        </div>
        <div class="form-group">
            <?= Html::submitButton('Submit', ['class' => 'btn btn-primary']) ?>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div><!-- aa -->
