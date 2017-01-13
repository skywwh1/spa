<?php

use kartik\date\DatePicker;
use kartik\typeahead\Typeahead;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Campaign */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="campaign-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class='form-group row'>
        <div class='col-lg-4'>
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
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'campaign_name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'campaign_uuid')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'pricing_mode')->dropDownList(ModelsUtil::pricing_mode) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?php
            echo '<label class="control-label">Promote</label>';
            echo DatePicker::widget([
                'name' => 'promote_start',
                'value' => Yii::$app->formatter->asDate('now', 'php:Y-m-d'),
                'type' => DatePicker::TYPE_RANGE,
                'name2' => 'promote_end',
                'value2' => Yii::$app->formatter->asDate('now', 'php:Y-m-d'),
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-MM-dd'
                ]
            ]);
            ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?php
            echo '<label class="control-label">End time</label>';
            echo DatePicker::widget([
                'name' => 'end_time',
                'type' => DatePicker::TYPE_INPUT,
                // 'value' => Yii::$app->formatter->asDate('now', 'php:Y-m-d'),
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-MM-dd'
                ]
            ]);
            ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'device')->dropDownList(ModelsUtil::device) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'platform')->dropDownList(ModelsUtil::platform) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-2'>
            <?= $form->field($model, 'daily_cap')->textInput() ?>
        </div>
        <div class='col-lg-2'>
            <?= $form->field($model, 'open_cap')->dropDownList(ModelsUtil::user_status) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'adv_price')->textInput() ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'now_payout')->textInput() ?>
        </div>
    </div>
    <div class='page-header'>
        <h4>Target Info</h4>
    </div>
    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'target_geo')->widget(Typeahead::classname(), [
                'pluginOptions' => ['highlight' => true],
                'options' => ['value' => isset($model->target_geo) ? $model->targetGeo->domain : '',],
                'dataset' => [
                    [
                        'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                        'display' => 'value',
                        'remote' => [
                            'url' => Url::to(['campaign/get_geo']) . '?name=%QUERY',
                            'wildcard' => '%QUERY'
                        ]
                    ]],
            ]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'traffice_source')->dropDownList(ModelsUtil::traffic_source) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'note')->textarea(['maxlength' => true]) ?>
        </div>
    </div>

    <div class='page-header'>
        <h4>Promotion Info</h4>
    </div>
    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'preview_link')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'icon')->textInput() ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'package_name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'app_name')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'app_size')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'category')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'version')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'app_rate')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>
        </div>
    </div>
    <div class='page-header'>
        <h4>Material Info</h4>
    </div>
    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'creative_link')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'creative_type')->dropDownList(ModelsUtil::create_type) ?>
        </div>
    </div>

    <div class='page-header'>
        <h4>CPA Info</h4>
    </div>
    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'carriers')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'conversion_flow')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class='page-header'>
        <h4>Operation Info</h4>
    </div>
    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'recommended')->dropDownList(ModelsUtil::user_status) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'indirect')->dropDownList(ModelsUtil::user_status) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'pm')->textInput() ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'bd')->textInput() ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'open_type')->dropDownList(ModelsUtil::open_type) ?>
        </div>
    </div>

    <div class='page-header'>
        <h4>Tech Info</h4>
    </div>
    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'subid_status')->dropDownList(ModelsUtil::user_status) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'track_way')->dropDownList(ModelsUtil::track_way) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'third_party')->dropDownList(ModelsUtil::user_status) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'track_link_domain')->textInput() ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'adv_link')->textInput(['maxlength' => true]) ?>
        </div>
    </div>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'ip_blacklist')->textarea(['maxlength' => true]) ?>
        </div>
    </div>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
