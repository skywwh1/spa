<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use common\models\Platform;
use kartik\select2\Select2;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;
use yii\web\JsExpression;
/* @var $this yii\web\View */
/* @var $model common\models\ChannelBlack */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-lg-6">
        <div class="box box-info">
            <div class="box-body">
                <div class="channel-black-form">

                    <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'advertiser')->widget(Typeahead::classname(), [
                            'pluginOptions' => ['highlight' => true],
                            'options' => ['value' => isset($model->advertiser0) ? $model->advertiser0->username : '',],
                            'dataset' => [
                                [
                                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                    'display' => 'value',
                                    'remote' => [
                                        'url' => Url::to(['campaign/get_adv_list']) . '?name=%QUERY',
                                        'wildcard' => '%QUERY'
                                    ]
                                ]],
                        ]) ?>
                        <?= $form->field($model, 'channel_name')->widget(Typeahead::classname(), [
                            'pluginOptions' => ['highlight' => true],
                            'options' => ['value' => isset($model->channel_name) ? $model->channel->username : ''],
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
                        <?php
                        echo $form->field($model, 'geo')->widget(Select2::classname(), [
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
                        <?= $form->field($model, 'action_type')->dropDownList(ModelsUtil::black_action) ?>
                        <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>
                        <div class="form-group">
                            <?= Html::submitButton($model->isNewRecord
                            ? 'Create'                        : 'Update', ['class' => $model->isNewRecord ? 'btn
                            btn-success' :
                            'btn btn-primary']) ?>
                        </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>