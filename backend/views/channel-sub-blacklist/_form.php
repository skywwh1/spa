<?php

use common\models\Platform;
use kartik\select2\Select2;
use kartik\typeahead\Typeahead;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ChannelSubBlacklist */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-lg-6">
        <div class="box box-info">
            <div class="box-body">
                <div class="channel-sub-blacklist-form">

                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'channel_name')->widget(Typeahead::classname(), [
                        'pluginOptions' => ['highlight' => true],
//                        'options' => ['value' => isset($model->master_channel) ? $model->masterChannel->username : '',],
                        'dataset' => [
                            [
                                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                'display' => 'value',
                                'remote' => [
                                    'url' => Url::to(['util/get-channel']) . '?name=%QUERY',
                                    'wildcard' => '%QUERY'
                                ]
                            ]],
                    ]) ?>
                    <?= $form->field($model, 'sub_channel')->textInput(['maxlength' => true]) ?>
                    <?php
                    echo $form->field($model, 'geo')->widget(Select2::classname(), [
//                'initValueText' => $model->target_geo, // set the initial display text
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
                    ]);
                    ?>
                    <?= $form->field($model, 'os')->checkboxList(
                        Platform::find()
                            ->select(['name', 'value'])
                            ->orderBy('id')
                            ->indexBy('value')
                            ->column()
                    ) ?>

                    <?php echo $form->field($model, 'category')->widget(Select2::classname(), [
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

                    <?= $form->field($model, 'note')->textarea(['row' => 6]) ?>

                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord
                            ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn
                        btn-success' :
                            'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>