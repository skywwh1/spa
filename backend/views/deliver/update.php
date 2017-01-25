<?php

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Deliver */

$this->title = 'Update S2S: ' . $model->channel->username . '-' . $model->campaign->campaign_uuid;
$this->params['breadcrumbs'][] = ['label' => 'Delivers', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->campaign->campaign_uuid, 'url' => ['view', 'campaign_id' => $model->campaign_id, 'channel_id' => $model->channel_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="STS"></div>
<div class="col-lg-12">
    <div class="box box-info">
        <div class="box-body">

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
                <?= Html::submitButton('Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
