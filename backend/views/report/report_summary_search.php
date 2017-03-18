<?php

use common\models\Category;
use common\models\Device;
use common\models\Platform;
use common\models\PriceModel;
use common\models\RegionsDomain;
use common\models\TrafficSource;
use kartik\date\DatePicker;
use kartik\typeahead\Typeahead;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ReportSummarySearch */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin([
    'action' => ['report-summary'],
    'method' => 'get',
]); ?>
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-solid">
            <div class="box-body">
                <h4>Filter</h4>
                <hr>
                <div class="row">

                    <div class="col-lg-2">
                        <?= $form->field($model, 'campaign_id')->textInput() ?>
                    </div>
                    <div class="col-lg-2">
                        <?= $form->field($model, 'campaign_uuid')->textInput() ?>
                    </div>
                    <div class="col-lg-2">
                        <?= $form->field($model, 'campaign_name')->textInput() ?>
                    </div>
                    <div class="col-lg-2">
                        <?= $form->field($model, 'adv_name')->widget(Typeahead::classname(), [
                            'pluginOptions' => ['highlight' => true],
//                        'options' => ['value' => isset($model->master_channel) ? $model->masterChannel->username : '',],
                            'dataset' => [
                                [
                                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                    'display' => 'value',
                                    'remote' => [
                                        'url' => Url::to(['util/get-adv']) . '?name=%QUERY',
                                        'wildcard' => '%QUERY'
                                    ]
                                ]],
                        ]) ?>

                    </div>
                    <div class="col-lg-2">
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

                    </div>

                </div>
                <div class="row">

                    <div class="col-lg-2">
                        <?= $form->field($model, 'subid')->textInput() ?>
                    </div>

                    <div class="col-lg-2">
                        <?= $form->field($model, 'pm')->widget(Typeahead::classname(), [
                            'pluginOptions' => ['highlight' => true],
                            'options' => ['value' => isset($model->pm) ? $model->pm : '',],
                            'dataset' => [
                                [
                                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                    'display' => 'value',
                                    'remote' => [
                                        'url' => Url::to(['util/get-user']) . '?u=%QUERY' . '&t=7',
                                        'wildcard' => '%QUERY'
                                    ]
                                ]],
                        ]) ?>

                    </div>
                    <div class="col-lg-2">
                        <?= $form->field($model, 'om')->widget(Typeahead::classname(), [
                            'pluginOptions' => ['highlight' => true],
                            'options' => ['value' => isset($model->om) ? $model->om : '',],
                            'dataset' => [
                                [
                                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                    'display' => 'value',
                                    'remote' => [
                                        'url' => Url::to(['util/get-user']) . '?u=%QUERY' . '&t=9',
                                        'wildcard' => '%QUERY'
                                    ]
                                ]],
                        ]) ?>

                    </div>

                    <div class="col-lg-2">
                        <?= $form->field($model, 'bd')->widget(Typeahead::classname(), [
                            'pluginOptions' => ['highlight' => true],
                            'options' => ['value' => isset($model->bd) ? $model->bd : '',],
                            'dataset' => [
                                [
                                    'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                    'display' => 'value',
                                    'remote' => [
                                        'url' => Url::to(['util/get-user']) . '?u=%QUERY' . '&t=8',
                                        'wildcard' => '%QUERY'
                                    ]
                                ]],
                        ]) ?>
                    </div>

                    <div class="col-lg-2">
                        <?= $form->field($model, 'geo')->dropDownList(
                            RegionsDomain::find()
                                ->select(['domain', 'domain'])
                                ->orderBy('id')
                                ->indexBy('domain')
                                ->column(),
                            ['prompt' => '-- select --']) ?>
                    </div>

                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <?= $form->field($model, 'category')->dropDownList(
                            Category::find()
                                ->select(['name', 'name'])
                                ->orderBy('id')
                                ->indexBy('name')
                                ->column(),
                            ['prompt' => '-- select --']) ?>
                    </div>
                    <div class="col-lg-2">
                        <?= $form->field($model, 'price_model')->dropDownList(
                            PriceModel::find()
                                ->select(['name', 'value'])
                                ->orderBy('id')
                                ->indexBy('value')
                                ->column(),
                            ['prompt' => '-- select --'])
                        ?>
                    </div>

                    <div class="col-lg-2">
                        <?= $form->field($model, 'platform')->dropDownList(
                            Platform::find()
                                ->select(['name', 'value'])
                                ->orderBy('id')
                                ->indexBy('value')
                                ->column(),
                            ['prompt' => '-- select --'])
                        ?>
                    </div>
                    <div class="col-lg-2">
                        <?= $form->field($model, 'device')->dropDownList(
                            Device::find()
                                ->select(['name', 'value'])
                                ->orderBy('id')
                                ->indexBy('value')
                                ->column(),
                            ['prompt' => '-- select --'])
                        ?>
                    </div>
                    <div class="col-lg-2">
                        <?= $form->field($model, 'traffic_source')->dropDownList(
                            TrafficSource::find()
                                ->select(['name', 'value'])
                                ->orderBy('id')
                                ->indexBy('value')
                                ->column(),
                            ['prompt' => '-- select --'])
                        ?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col-lg-4">
                        <?php
                        echo '<label class="control-label">Date</label>';
                        echo DatePicker::widget([
                            'name' => 'ReportSummarySearch[start]',
                            'value' => isset($model->start) ? $model->start : Yii::$app->formatter->asDate('now', 'php:Y-m-d'),
                            'type' => DatePicker::TYPE_RANGE,
                            'name2' => 'ReportSummarySearch[end]',
                            'value2' => isset($model->end) ? $model->end : Yii::$app->formatter->asDate('now', 'php:Y-m-d'),
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]);
                        ?>
                    </div>
                    <div class="col-lg-2">
                        <?= $form->field($model, 'time_zone')->dropDownList(ModelsUtil::timezone, ['value' => !empty($model->time_zone) ? $model->time_zone : 'Etc/GMT-8']) ?>
                    </div>

                    <div class="col-lg-2">
                        <?= $form->field($model, 'type')->dropDownList([
                            2 => 'Daily',
                            1 => 'Hourly',
                        ],['prompt' => '-- select --']) ?>
                    </div>
                </div>

            </div>
            <!-- /.box-body -->

            <div class="box-footer">
                <?= Html::submitButton('Report', ['class' => 'btn btn-primary']) ?>
                <?php // Html::resetButton('Reset', ['class' => 'btn btn-default']) ?>
            </div>
        </div>
        <!-- /.box -->
        <?php ActiveForm::end(); ?>

    </div>
</div>





