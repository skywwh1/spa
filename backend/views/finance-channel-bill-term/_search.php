<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\date\DatePicker;
use kartik\typeahead\Typeahead;

/* @var $this yii\web\View */
/* @var $model backend\models\FinanceChannelBillTermSearch */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <?php $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
            ]); ?>
            <div class="box-body">
                <div class="row">
                    <div class="col-lg-2">
                        <?= $form->field($model, 'master_channel')->widget(Typeahead::classname(), [
                            'pluginOptions' => ['highlight' => true],
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
                    <div class="col-lg-2">
                        <?= $form->field($model, 'channel')->widget(Typeahead::classname(), [
                            'pluginOptions' => ['highlight' => true],
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
                    <div class="col-lg-2">
                        <?= $form->field($model, 'bill_id') ?>
                    </div>
                    <div class="col-lg-2">
                        <?= $form->field($model, 'status')->dropDownList(
                            ModelsUtil::compensation_status,
                            ['prompt' => '-- select --']) ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-2">
                        <?= $form->field($model, 'level')->dropDownList(
                            ModelsUtil::channel_level,
                            ['prompt' => '-- select --']) ?>
                    </div>
                    <div class="col-lg-4">
                        <?php
                        echo '<label class="control-label">Date</label>';
                        echo DatePicker::widget([
                            'name' => 'FinanceChannelBillTermSearch[start_time]',
                            'value' => isset($model->start_time) ? $model->start_time : Yii::$app->formatter->asDate('now', 'php:Y-m'),
                            'type' => DatePicker::TYPE_RANGE,
                            'name2' => 'FinanceChannelBillTermSearch[end_time]',
                            'value2' => isset($model->end_time) ? $model->end_time : Yii::$app->formatter->asDate('now', 'php:Y-m'),
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm'
                            ]
                        ]);
                        ?>
                    </div>
                </div>
                <div class="form-group">
                    <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
