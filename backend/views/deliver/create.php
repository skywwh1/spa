<?php

use kartik\select2\Select2;
use yii\bootstrap\ButtonDropdown;
use yii\helpers\Html;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;
use kartik\typeahead\TypeaheadBasic;
use kartik\typeahead\Typeahead;
use yii\helpers\Url;
use yii\bootstrap\Modal;

/* @var $this yii\web\View */
/* @var $model common\models\Deliver */

$this->title = 'Create S2S';
$this->params['breadcrumbs'][] = ['label' => 'Delivers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">
    <div id="nav-menu" data-menu="STS"></div>
    <div class="col-lg-6">
        <div class="box box-info">
            <div class="box-body">

                <?php $form = ActiveForm::begin([
//                    'id' => 'form-id',
//                    'enableAjaxValidation' => true,
//                    'validationUrl' => Url::toRoute(['sts-validate']),
                    'options' => ['class' => 'black_channel_form'],
                ]); ?>

                <?php
                //            $form->field($model, 'campaign_uuid')->widget(Typeahead::classname(), [
                //                'options' => ['placeholder' => 'Campaign UUID'],
                //                'pluginOptions' => ['highlight' => true],
                //                'dataset' => [
                //                    [
                //                        'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                //                        'display' => 'value',
                //                        'remote' => [
                //                            'url' => Url::to(['campaign/campaigns_by_uuid']) . '?uuid=%QUERY',
                //                            'wildcard' => '%QUERY'
                //                        ]
                //                    ]],
                //            ])
                echo $form->field($model, 'campaign_uuid')->widget(Select2::classname(), [
//                'initValueText' => $cityDesc, // set the initial display text
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
                            'url' => Url::to('/campaign/get_campaign_uuid_multiple'),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {uuid:params.term}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(campaign) { return campaign.campaign_uuid; }'),
                        'templateSelection' => new JsExpression('function (campaign) { return campaign.campaign_uuid; }'),
                    ],
                    ])->label("Campaign ID-UUID");
                ?>

                <?php
                //            $form->field($model, 'channel')->widget(Typeahead::classname(), [
                //                'options' => ['placeholder' => 'Channel'],
                //                'pluginOptions' => ['highlight' => true],
                //                'dataset' => [
                //                    [
                //                        'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                //                        'display' => 'value',
                //                        'remote' => [
                //                            'url' => Url::to(['channel/get_channel_name']) . '?name=%QUERY',
                //                            'wildcard' => '%QUERY'
                //                        ]
                //                    ]],
                //            ])
                echo $form->field($model, 'channel')->widget(Select2::classname(), [
//                'initValueText' => $cityDesc, // set the initial display text
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
                            'url' => Url::to('/channel/get_channel_multiple'),
                            'dataType' => 'json',
                            'data' => new JsExpression('function(params) { return {name:params.term}; }')
                        ],
                        'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                        'templateResult' => new JsExpression('function(channel) { return channel.username; }'),
                        'templateSelection' => new JsExpression('function (channel) { return channel.username; }'),
                    ],
                ]);
                ?>
                <?= $form->field($model, 'step')->hiddenInput(['value' => 1])->label(false) ?>

                <div class="form-group">
                    <?= Html::submitButton('Go ahead', ['class' => 'btn btn-success']) ?>
                </div>

                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</div>
<?php //Modal::begin([
//    'id' => 'black-channel-modal',
//    'size' => 'modal-lg',
//    'clientOptions' => [
//        'backdrop' => 'static',
//        'keyboard' => false,
//    ],
//]);
//
//echo '<div id="black-channel-content"></div>';
//
////Modal::end(); ?>
<?php
//$this->registerJsFile(
//    '@web/js/black-channel.js',
//    ['depends' => [\yii\web\JqueryAsset::className()]]
//);
//?>