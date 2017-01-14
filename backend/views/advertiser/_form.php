<?php

use kartik\typeahead\Typeahead;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Advertiser */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="advertiser-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'settlement_type')->dropDownList(ModelsUtil::settlement_type) ?>

        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'pm')->textInput(['maxlength' => true, 'readonly' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'bd')->widget(Typeahead::classname(), [
                'pluginOptions' => ['highlight' => true],
                'options' => ['value' => isset($model->bd) ? $model->bd0->username : '',],
                'dataset' => [
                    [
                        'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                        'display' => 'value',
                        'remote' => [
                            'url' => Url::to(['advertiser/get_bd']) . '?bd=%QUERY',
                            'wildcard' => '%QUERY'
                        ]
                    ]],
            ]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'contacts')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'system')->dropDownList(ModelsUtil::system) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'post_parameter')->textInput(['value' => 'click_id', 'readonly' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'cc_email')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'status')->dropDownList(ModelsUtil::advertiser_status) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'pricing_mode')->dropDownList(ModelsUtil::pricing_mode) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'skype')->textInput() ?>
        </div>
    </div>
    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'phone1')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'note')->textarea(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
