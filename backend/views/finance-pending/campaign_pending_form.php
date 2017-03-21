<?php

use kartik\date\DatePicker;
use kartik\typeahead\Typeahead;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\FinancePending */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-lg-6">
        <div class="box box-info">
            <div class="box-body">
                <div class="finance-pending-form">

                    <?php $form = ActiveForm::begin(); ?>
                    <div class="row">
                        <div class="col-lg-6">
                            <?= $form->field($model, 'campaign_id')->textInput() ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
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
                        <div class="col-lg-6">
                            <div class="form-group  required">
                                <label class="control-label" for="financepending-channel_id">All Channel</label>
                                <input type="text" id="financepending-channel_id" class="form-control"
                                       name="FinancePending[channel_id]" aria-required="true" aria-invalid="true">

                            </div>
                        </div>
                    </div>
                    <div class="form-group field-financepending-start_date required">
                        <?php
                        echo '<label class="control-label">Date</label>';
                        echo DatePicker::widget([
                            'name' => 'FinancePending[start_date]',
                            'value' => isset($model->start_date) ? $model->start_date : Yii::$app->formatter->asDate('now', 'php:Y-m-d'),
                            'type' => DatePicker::TYPE_RANGE,
                            'name2' => 'FinancePending[end_date]',
                            'value2' => isset($model->end_date) ? $model->end_date : Yii::$app->formatter->asDate('now', 'php:Y-m-d'),
                            'pluginOptions' => [
                                'autoclose' => true,
                                'format' => 'yyyy-mm-dd'
                            ]
                        ]);
                        ?>
                        <div class="help-block"></div>
                    </div>

                    <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>
                    <div class="form-group">
                        <?= Html::submitButton('Create', ['class' => 'btn-success']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>

                </div>
            </div>
        </div>
    </div>
</div>