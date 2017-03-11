<?php

use common\models\Category;
use common\models\Device;
use common\models\Platform;
use common\models\PriceModel;
use common\models\TrafficSource;
use kartik\date\DatePicker;
use kartik\select2\Select2;
use kartik\typeahead\Typeahead;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Campaign */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>
<div class="col-md-6">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Base Info</h3>
        </div>
        <div class="box-body">

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

            <?= $form->field($model, 'campaign_name')->textInput(['maxlength' => true]) ?>
            <?php if (isset($model->campaign_uuid)) {
                echo $form->field($model, 'campaign_uuid')->textInput(['maxlength' => true, 'readonly' => 'readonly']);
            } else {
                echo $form->field($model, 'campaign_uuid')->textInput(['maxlength' => true,]);
            } ?>
            <?= $form->field($model, 'pricing_mode')->dropDownList(
                PriceModel::find()
                    ->select(['name', 'value'])
                    ->orderBy('id')
                    ->indexBy('value')
                    ->column()
            ) ?>

            <?php
            echo '<label class="control-label">Promote start</label>';
            echo DatePicker::widget([
                'name' => 'Campaign[promote_start]',
                'type' => DatePicker::TYPE_INPUT,
                'value' => isset($model->promote_start) ? date("Y-m-d", $model->promote_start) : Yii::$app->formatter->asDate('now', 'php:Y-m-d'),
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]);
            ?>

            <?php
            echo '<label class="control-label">End time</label>';
            echo DatePicker::widget([
                'name' => 'Campaign[promote_end]',
                'type' => DatePicker::TYPE_INPUT,
                'value' => isset($model->promote_end) ? date("Y-m-d", $model->promote_start) : '',
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd'
                ]
            ]);
            ?>

            <?php // $form->field($model, 'effective_time')->textInput() ?>
            <?php // $form->field($model, 'adv_update_time')->textInput() ?>
            <?= $form->field($model, 'device')->checkboxList(
                Device::find()
                    ->select(['name', 'value'])
                    ->orderBy('id')
                    ->indexBy('value')
                    ->column()
            ) ?>

            <?= $form->field($model, 'platform')->dropDownList(
                Platform::find()
                    ->select(['name', 'value'])
                    ->orderBy('id')
                    ->indexBy('value')
                    ->column()
            ) ?>
            <?= $form->field($model, 'min_version')->textInput(['maxlength' => true]) ?>
            <?= $form->field($model, 'max_version')->textInput(['maxlength' => true]) ?>
            <div class='form-group row'>
                <div class='col-xs-5'>
                    <?= $form->field($model, 'daily_cap')->textInput() ?>
                </div>
                <div class='col-xs-5'>
                    <div class="form-group">
                        <label class="control-label" for="campaign-daily_cap">Open Cap</label>
                        <?= Html::dropDownList('open_cap', '0', ModelsUtil::user_status, ['class' => 'form-control']) // $form->field($model, 'open_cap')->dropDownList(ModelsUtil::user_status)      ?>
                    </div>
                </div>
            </div>

            <?= $form->field($model, 'adv_price')->textInput() ?>

            <?= $form->field($model, 'now_payout')->textInput() ?>
        </div>
    </div>
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Material Info</h3>
        </div>
        <div class="box-body">
            <?= $form->field($model, 'creative_link')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'creative_type')->dropDownList(ModelsUtil::create_type) ?>
        </div>
    </div>
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">CPA Info</h3>
        </div>
        <div class="box-body">
            <?= $form->field($model, 'carriers')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'conversion_flow')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Operation Info</h3>
        </div>
        <div class="box-body">
            <?= $form->field($model, 'recommended')->dropDownList(ModelsUtil::user_status) ?>

            <?= $form->field($model, 'indirect')->dropDownList(ModelsUtil::user_status) ?>

            <?= $form->field($model, 'open_type')->dropDownList(ModelsUtil::open_type) ?>

            <?= $form->field($model, 'tag')->dropDownList(ModelsUtil::campaign_tag) ?>
        </div>
    </div>

</div>
<div class="col-md-6">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Target Info</h3>
        </div>
        <div class="box-body">
            <?php
            //            $form->field($model, 'target_geo')->widget(Typeahead::classname(), [
            //                'pluginOptions' => ['highlight' => true],
            //                'options' => ['value' => $model->target_geo],
            //                'dataset' => [
            //                    [
            //                        'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
            //                        'display' => 'value',
            //                        'remote' => [
            //                            'url' => Url::to(['campaign/get_geo']) . '?name=%QUERY',
            //                            'wildcard' => '%QUERY'
            //                        ]
            //                    ]],
            //            ])
            echo $form->field($model, 'target_geo')->widget(Select2::classname(), [
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
            <?= $form->field($model, 'traffic_source')->checkboxList(
                TrafficSource::find()
                    ->select(['name', 'value'])
                    ->orderBy('id')
                    ->indexBy('value')
                    ->column()
            ) ?>
            <?php // $form->field($model, 'traffic_source')->dropDownList(ModelsUtil::traffic_source) ?>
            <?= $form->field($model, 'note')->textarea(['maxlength' => true]) ?>
        </div>
    </div>
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Promotion Info</h3>
        </div>
        <div class="box-body">
            <?= $form->field($model, 'preview_link')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'icon')->textInput() ?>

            <?= $form->field($model, 'package_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'app_name')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'app_size')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'category')->dropDownList(
                Category::find()
                    ->select(['name', 'name'])
                    ->orderBy('id')
                    ->indexBy('name')
                    ->column(),
                ['prompt' => 'Select category ...']) ?>

            <?= $form->field($model, 'version')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'app_rate')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>
        </div>
    </div>
</div>


<div class="col-md-6">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Tech Info</h3>
        </div>
        <div class="box-body">
            <?= $form->field($model, 'subid_status')->dropDownList(ModelsUtil::user_status) ?>

            <?= $form->field($model, 'track_way')->dropDownList(ModelsUtil::track_way) ?>

            <?= $form->field($model, 'third_party')->dropDownList(ModelsUtil::user_status) ?>

            <?= $form->field($model, 'track_link_domain')->textInput() ?>

            <?= $form->field($model, 'adv_link')->textInput(['maxlength' => true]) ?>

            <?= $form->field($model, 'ip_blacklist')->textarea(['maxlength' => true]) ?>

            <div class="form-group">
                <?= Html::submitButton($model->isNewRecord ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>


        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>
<?php $this->registerJsFile('@web/js/campaign.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]);
?>
