<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\S2s */

$this->title = 'Update S2s: ' . $model->campaign_id;
$this->params['breadcrumbs'][] = ['label' => 'S2s', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->campaign_id, 'url' => ['view', 'campaign_id' => $model->campaign_id, 'channel_id' => $model->channel_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="s2s-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="s2s-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class='form-group row'>
            <div class='col-lg-4'>
                <?= $form->field($model, 'campaign_uuid')->textInput() ?>
            </div>
        </div>

        <div class='form-group row'>
            <div class='col-lg-4'>
                <?= $form->field($model, 'channel_id')->textInput() ?>
            </div>
        </div>

        <div class='form-group row'>
            <div class='col-lg-4'>
                <?= $form->field($model, 'pay_out')->textInput() ?>
            </div>
        </div>

        <div class='form-group row'>
            <div class='col-lg-4'>
                <?= $form->field($model, 'daily_cap')->textInput() ?>
            </div>
        </div>

        <div class='form-group row'>
            <div class='col-lg-4'>
                <?= $form->field($model, 'discount')->textInput() ?>
            </div>
        </div>

        <div class='form-group row'>
            <div class='col-lg-4'>
                <?= $form->field($model, 'is_run')->textInput() ?>
            </div>
        </div>

        <div class='form-group row'>
            <div class='col-lg-4'>
                <?= $form->field($model, 'creator')->textInput() ?>
            </div>
        </div>

        <div class="form-group">
            <?= Html::submitButton( 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
