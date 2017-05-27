<?php

use common\models\PriceModel;
use common\models\System;
use kartik\typeahead\Typeahead;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Advertiser */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="col-lg-6">
    <div class="box box-info">
        <div class="box-body">

            <?php $form = ActiveForm::begin(); ?>

            <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'payment_term')->dropDownList(ModelsUtil::payment_term) ?>

            <?= $form->field($model, 'beneficiary_name')->textInput() ?>

            <?= $form->field($model, 'bank_country')->textInput(['maxlength' => true]) ?>


            <?= $form->field($model, 'bank_name')->textInput(['maxlength' => true]) ?>


            <?= $form->field($model, 'bank_address')->textInput(['maxlength' => true]) ?>


            <?= $form->field($model, 'swift')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'account_nu_iban')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'pm')->textInput(['maxlength' => true, 'readonly' => true]) ?>
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

            <?= $form->field($model, 'contacts')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'system')->dropDownList(
                System::find()
                    ->select(['name','value'])
                    ->orderBy('id')
                    ->indexBy('value')
                    ->column()
            ) ?>
            <?= $form->field($model, 'post_parameter')->textInput(['placeholder' => 'ex: tx={click_id}&publisher={ch_id}']) ?>
            <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'cc_email')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'status')->dropDownList(ModelsUtil::advertiser_status) ?>
            <?= $form->field($model, 'pricing_mode')->dropDownList(
                PriceModel::find()
                    ->select(['name','value'])
                    ->orderBy('id')
                    ->indexBy('value')
                    ->column()
            ) ?>
            <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'address')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'skype')->textInput() ?>
            <?= $form->field($model, 'phone1')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'invoice_title')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'timezone')->dropDownList(ModelsUtil::timezone) ?>
            <?= $form->field($model, 'note')->textarea(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
