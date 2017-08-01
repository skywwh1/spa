<?php

use kartik\date\DatePicker;
use kartik\typeahead\Typeahead;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

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
                <div class="col-lg-2">
                    <?= $form->field($model, 'time_zone')->dropDownList(ModelsUtil::timezone,  ['prompt' => '-- select --']) ?>
                </div>

                </div>
                <div class="row">
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
                        <?= $form->field($model, 'status')->dropDownList(
                            [
                                6 => 'Payable',
                                7 => 'Paid',
                                8 => 'Overdue',
                            ],
                            ['prompt' => '-- select --']) ?>
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





