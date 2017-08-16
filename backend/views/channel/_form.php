<?php

use common\models\PriceModel;
use common\models\System;
use common\models\TrafficSource;
use kartik\select2\Select2;
use kartik\typeahead\Typeahead;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use common\models\Platform;
use kartik\file\FileInput;
/* @var $this yii\web\View */
/* @var $model common\models\Channel */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-lg-6">
        <div class="box box-info">
            <div class="box-body">
                <div class="channel-form">
                    <?php $form = ActiveForm::begin([
                        'options'=>['enctype'=>'multipart/form-data'] // important
                    ]); ?>
                    <?= $form->field($model, 'username')->textInput(['maxlength' => true, 'readonly' => $model->isNewRecord ? false : 'readonly']) ?>
                    <?php echo $form->field($model, 'filename');

                    // display the image uploaded or show a placeholder
                    // you can also use this code below in your `view.php` file
                    $title = isset($model->filename) && !empty($model->filename) ? $model->filename : 'Avatar';
                    echo Html::img($model->getImageUrlAbs(), [
                    'class'=>'img-thumbnail',
                    'alt'=>$title,
                    'title'=>$title
                    ]);

                    // your fileinput widget for single file upload
                    echo $form->field($model, 'image')->widget(FileInput::classname(), [
                    'options'=>['accept'=>'image/*'],
                    'pluginOptions'=>['allowedFileExtensions'=>['jpg','gif','png'],
                        ],
                    ]);
                    ?>

                    <?= $form->field($model, 'password_hash')->passwordInput() ?>

                    <?= $form->field($model, 'om')->widget(Typeahead::classname(), [
                        'pluginOptions' => ['highlight' => true],
                        'options' => ['value' => isset($model->om0) ? $model->om0->username : '',],
                        'dataset' => [
                            [
                                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                'display' => 'value',
                                'remote' => [
                                    'url' => Url::to(['channel/get_om']) . '?om=%QUERY',
                                    'wildcard' => '%QUERY'
                                ]
                            ]],
                    ]) ?>

                    <?= $form->field($model, 'master_channel')->widget(Typeahead::classname(), [
                        'pluginOptions' => ['highlight' => true],
                        'options' => ['value' => isset($model->master_channel) ? $model->masterChannel->username : '','readonly' => $model->isNewRecord ? false : 'readonly'],
                        'dataset' => [
                            [
                                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                'display' => 'value',
                                'remote' => [
                                    'url' => Url::to(['channel/get_channel_name']) . '?name=%QUERY',
                                    'wildcard' => '%QUERY'
                                ]
                            ]],
                    ]) ?>

                    <?= $form->field($model, 'payment_way')->checkboxList(ModelsUtil::payment_way) ?>

                    <?= $form->field($model, 'payment_term')->dropDownList(ModelsUtil::payment_term) ?>

                    <?= $form->field($model, 'beneficiary_name')->textInput() ?>

                    <?= $form->field($model, 'bank_country')->textInput(['maxlength' => true]) ?>


                    <?= $form->field($model, 'bank_name')->textInput(['maxlength' => true]) ?>


                    <?= $form->field($model, 'bank_address')->textInput(['maxlength' => true]) ?>


                    <?= $form->field($model, 'swift')->textInput(['maxlength' => true]) ?>


                    <?= $form->field($model, 'account_nu_iban')->textInput(['maxlength' => true]) ?>


                    <?= $form->field($model, 'company_address')->textInput(['maxlength' => true]) ?>

                    <?php
                       if(empty($model->discount)){
                            echo $form->field($model, 'discount')->textInput(['value' => 30]);
                       }else{
                           echo $form->field($model, 'discount')->textInput();
                       }
                    ?>

                    <?= $form->field($model, 'daily_cap')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'pay_out')->dropDownList([
                            0=>'Payout',
                            1=>'ADV price'
                    ]) ?>

                    <?= $form->field($model, 'note')->textarea(['maxlength' => true]) ?>

                    <?= $form->field($model, 'contacts')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'system')->dropDownList(
                        System::find()
                            ->select(['name', 'value'])
                            ->orderBy('id')
                            ->indexBy('value')
                            ->column()
                    ) ?>


                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'cc_email')->textInput(['maxlength' => true, 'placeholder' => 'Multiple: aaa@example.com;ccc@example.com']) ?>

                    <?= $form->field($model, 'country')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'company')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'phone1')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'skype')->textInput(['maxlength' => true]) ?>


                    <?= $form->field($model, 'status')->dropDownList(ModelsUtil::advertiser_status) ?>

                    <?= $form->field($model, 'traffic_source')->checkboxList(
                        TrafficSource::find()
                            ->select(['name', 'value'])
                            ->orderBy('id')
                            ->indexBy('value')
                            ->column()
                    ) ?>
                    <?php // $form->field($model, 'traffic_source')->dropDownList(ModelsUtil::traffic_source) ?>

                    <?= $form->field($model, 'pricing_mode')->dropDownList(
                        PriceModel::find()
                            ->select(['name', 'value'])
                            ->orderBy('id')
                            ->indexBy('value')
                            ->column()
                    ) ?>


                    <?= $form->field($model, 'post_back')->textInput(['maxlength' => true]) ?>
                    <?= $form->field($model, 'event_post_back')->textInput(['maxlength' => true]) ?>

                    <?= $form->field($model, 'os')->checkboxList(
                        Platform::find()
                            ->select(['name', 'value'])
                            ->orderBy('id')
                            ->indexBy('value')
                            ->column()
                    ) ?>

                    <?php
                    echo $form->field($model, 'strong_geo')->widget(Select2::classname(), [
//                        'initValueText' => $model->strong_geo, // set the initial display text
                        'size' => Select2::MEDIUM,
                        'options' => [
                            'multiple' => true,
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 1,
                            'language' => [
                                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                            ],
                            'ajax' => [
                                'url' => Url::to(['util/geo']),
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {name:params.term}; }')
                            ],
                            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            'templateResult' => new JsExpression('function(campaign) { return campaign.text; }'),
                            'templateSelection' => new JsExpression('function (campaign) { return campaign.text; }'),
                        ],
                    ]); ?>

                    <?php echo $form->field($model, 'strong_category')->widget(Select2::classname(), [
//                        'initValueText' => $model->strong_category, // set the initial display text
                        'size' => Select2::MEDIUM,
                        'options' => [
                            'multiple' => true,
                        ],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'minimumInputLength' => 1,
                            'language' => [
                                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                            ],
                            'ajax' => [
                                'url' => Url::to(['util/category']),
                                'dataType' => 'json',
                                'data' => new JsExpression('function(params) { return {name:params.term}; }')
                            ],
                            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                            'templateResult' => new JsExpression('function(campaign) { return campaign.text; }'),
                            'templateSelection' => new JsExpression('function (campaign) { return campaign.text; }'),
                        ],
                    ]); ?>
                    <?= $form->field($model, 'level')->dropDownList(ModelsUtil::channel_level) ?>
                    <?= $form->field($model, 'create_type')->dropDownList(ModelsUtil::channel_create_type) ?>
                    <?= $form->field($model, 'recommended')->dropDownList(ModelsUtil::status) ?>

                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div><?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>