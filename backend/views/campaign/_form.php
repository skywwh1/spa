<?php

use common\models\Category;
use kartik\date\DatePicker;
use kartik\typeahead\Typeahead;
use yii\helpers\Html;
use yii\helpers\Url;
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
                <?= $form->field($model, 'campaign_uuid')->textInput(['maxlength' => true]) ?>

                <?= $form->field($model, 'pricing_mode')->dropDownList(ModelsUtil::pricing_mode) ?>

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
                        'format' => 'yyyy-mm-dd'
                    ]
                ]);
                ?>

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

                <?= $form->field($model, 'device')->dropDownList(ModelsUtil::device) ?>

                <?= $form->field($model, 'platform')->dropDownList(ModelsUtil::platform) ?>

                <div class='form-group row'>
                    <div class='col-xs-5'>
                        <?= $form->field($model, 'daily_cap')->textInput() ?>
                    </div>
                    <div class='col-xs-5'>
                        <?= $form->field($model, 'open_cap')->dropDownList(ModelsUtil::user_status) ?>
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
            </div>
        </div>

    </div>
    <div class="col-md-6">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Target Info</h3>
            </div>
            <div class="box-body">
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
                <?= $form->field($model, 'traffice_source')->dropDownList(ModelsUtil::traffic_source) ?>
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
                            ->select(['name','id'])
                            ->orderBy('id')
                            ->indexBy('id')
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