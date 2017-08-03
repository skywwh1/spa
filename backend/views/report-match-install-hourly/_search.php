<?php

use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ReportMatchInstallHourlySearch */
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
                <div class='col-lg-2'>
                    <?= $form->field($model, 'campaign_id')->textInput() ?>
                </div>
                <div class="col-lg-2">
                    <?= $form->field($model, 'campaign_name')->textInput() ?>
                </div>
                <div class="col-lg-4">
                    <?php
                    echo '<label class="control-label">Date</label>';
                    echo DatePicker::widget([
                        'name' => 'ReportSearch[start]',
                        'value' => isset($model->start) ? $model->start : Yii::$app->formatter->asDate('now', 'php:Y-m-d'),
                        'type' => DatePicker::TYPE_RANGE,
                        'name2' => 'ReportSearch[end]',
                        'value2' => isset($model->end) ? $model->end : Yii::$app->formatter->asDate('now', 'php:Y-m-d'),
                        'pluginOptions' => [
                            'autoclose' => true,
                            'format' => 'yyyy-mm-dd'
                        ]
                    ]);
                    ?>
                </div>
                <div class="col-lg-2">
                    <?= $form->field($model, 'time_zone')->dropDownList(ModelsUtil::timezone,['value' => !empty($model->time_zone) ? $model->time_zone :'Etc/GMT-8']) ?>
                </div>
                <div class="col-lg-2">
                    <?= $form->field($model, 'type')->dropDownList([
                        2 => 'Daily',
                        1 => 'Hourly',
                    ],['prompt' => '-- select --']) ?>
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
