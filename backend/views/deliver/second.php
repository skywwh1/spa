<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Deliver */

$this->title = 'Create S2S';
$this->params['breadcrumbs'][] = ['label' => 'S2s', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="s2s-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'campaign_uuid')->textInput(['readonly' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'channel0')->textInput(['readonly' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'pricing_mode')->dropDownList(ModelsUtil::pricing_mode) ?>
        </div>
    </div>
    <div class='form-group row'>
        <div class='col-lg-4'>
            <div class="form-group col-lg-4">
                <label class="control-label">Adv price:</label>
            </div>
            <div class="form-group col-lg-4">
                <label class="control-label"><?= $model->adv_price?></label>
            </div>
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
            <?= $form->field($model, 'note')->textarea() ?>
        </div>
    </div>

    <?= $form->field($model, 'step')->hiddenInput(['value' => 2])->label(false) ?>
    <?= $form->field($model, 'campaign_id')->hiddenInput()->label(false) ?>
    <?= $form->field($model, 'channel_id')->hiddenInput()->label(false) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Go Back', ['deliver/create'], array('class' => 'btn btn-primary')) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
