<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\Url;
use kartik\date\DatePicker;
use kartik\typeahead\Typeahead;

/* @var $this yii\web\View */
/* @var $model backend\models\FinancePending */

$this->title = 'Add ADV Pending';
$this->params['breadcrumbs'][] = ['label' => 'Finance Pending', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="finance-pending-index"></div>
<div class="finance-pending-update">
    <div class="row">
        <div class="col-lg-6">
            <div class="box box-info">
                <div class="box-body">
                    <div class="finance-pending-form">

                        <?php $form = ActiveForm::begin([
//                            'enableAjaxValidation' => true,
//                            'validationUrl' => '/finance-pending/validate',
                        ]); ?>
                        <div class="row">
                            <div class="col-lg-6">
                                <?= $form->field($model, 'adv_name')->textInput(['readonly' => 'readonly']); ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-6">
                                <?= $form->field($model, 'channel_name')->textInput(['readonly' => 'readonly']); ?>
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
</div>
<?php
$this->registerJsFile(
    '@web/js/finance-pending-campaign.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]
);
?>