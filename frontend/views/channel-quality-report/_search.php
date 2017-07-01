<?php

use yii\helpers\Html;
use kartik\date\DatePicker;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\ChannelQualityReportSearch */
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
                    <div class='col-lg-2'>
                        <?= $form->field($model, 'campaign_id')->textInput() ?>
                    </div>
                    <div class="col-lg-4">
                        <?php
                        echo '<label class="control-label">Date</label>';
                        echo DatePicker::widget([
                            'name' => 'ChannelQualityReportSearch[start]',
                            'value' => isset($model->start) ? $model->start : Yii::$app->formatter->asDate('now', 'php:Y-m-d'),
                            'type' => DatePicker::TYPE_RANGE,
                            'name2' => 'ChannelQualityReportSearch[end]',
                            'value2' => isset($model->end) ? $model->end : Yii::$app->formatter->asDate('now', 'php:Y-m-d'),
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]);
                        ?>

                    </div>
                    <div class='col-lg-1'>
                        <?php
                        echo '<label class="control-label"></label>';
                        ?>
                        <button type="button" id = 'weekButton' class="btn btn-primary" style="vertical-align:middle;">Last Week</button>
                        <?= $form->field($model, 'type')->hiddenInput()->label(false) ?>
                    </div>
                    <div class='col-lg-1'>
                        <?php
                        echo '<label class="control-label"></label>';
                        ?>
                        <button type="button" id = 'monthButton' class="btn btn-primary" style="vertical-align:middle;">Last Month</button>
                    </div>
                </div>
                <div class="box-footer">
                    <?= Html::submitButton('Report', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <!-- /.box-body -->


        </div>
        <!-- /.box -->
        <?php ActiveForm::end(); ?>

    </div>
</div>