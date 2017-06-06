<?php

use kartik\date\DatePicker;
use kartik\typeahead\Typeahead;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\FinancePendingForm */
/* @var $form yii\widgets\ActiveForm */
?>
    <div class="row">
        <div class="col-lg-6">
            <div class="box box-info">
                <div class="box-body">
                    <div class="finance-pending-form">

                        <?php $form = ActiveForm::begin([
                            'enableAjaxValidation' => true,
                            'validationUrl' => '/finance-pending/validate',
                        ]); ?>
                        <div class="row">
                            <div class="col-lg-6">
                                <?php
                                if (is_null($model->adv_name)){
                                    echo $form->field($model, 'adv_name')->widget(Typeahead::classname(), [
                                        'pluginOptions' => ['highlight' => true],
                                        'options' => ['value' => $model->adv_name,],
                                        'dataset' => [
                                            [
                                                'datumTokenizer' => "Bloodhound.tokenizers.obj.whitespace('value')",
                                                'display' => 'value',
                                                'remote' => [
                                                    'url' => Url::to(['campaign/get_adv_list']) . '?name=%QUERY',
                                                    'wildcard' => '%QUERY'
                                                ]
                                            ]],
                                    ]);
                                }else{
                                    echo $form->field($model, 'adv_name')->textInput(['readonly' => 'readonly']);
                                }
                                ?>

                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                            <?php
                            if (is_null($model->channel_name)){
                                echo $form->field($model, 'channel_name')->widget(Typeahead::classname(), [
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
                                ]);
                            }else{
                                echo $form->field($model, 'channel_name')->textInput(['readonly' => 'readonly']);
                            }
                            ?>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group  required">
                                    <label class="control-label" for="financepending-channel_id">All Channel</label>
                                    <?= Html::dropDownList('FinancePending[is_all]', '0', ModelsUtil::user_status, ['class' => 'form-control', 'id' => 'campaign-pending-all']) ?>
                                </div>
                            </div>
                        </div>
                        <div class="form-group field-financepending-start_date required">
                            <?php
                            echo '<label class="control-label">Date</label>';
                            echo DatePicker::widget([
                                'name' => 'FinancePendingForm[start_date]',
                                'value' => isset($model->start_date) ? $model->start_date : Yii::$app->formatter->asDate('now', 'php:Y-m-d'),
                                'type' => DatePicker::TYPE_RANGE,
                                'name2' => 'FinancePendingForm[end_date]',
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
                        <?= $form->field($model, 'type')->hiddenInput(['value' => 2])->label(false) ?>
                        <div class="form-group">
                            <?= Html::submitButton('Create', ['class' => 'btn-success']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
<?php
$this->registerJsFile(
    '@web/js/finance-pending-campaign.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>