<?php
use kartik\date\DatePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\RedirectLog */
/* @var $form yii\widgets\ActiveForm */
?>
    <div class="redirect-log-form">
    <h3>Redirect Option</h3>
        <?php $form = ActiveForm::begin([
            'id' => 'redirect-form',
            'enableAjaxValidation' => true,
            'validationUrl' => '/redirect-log/validate',
        ]); ?>

        <?= $form->field($model, 'campaign_id')->textInput(['readonly' => true]) ?>
        <?= $form->field($model, 'channel_id')->textInput(['readonly' => true]) ?>
        <?= $form->field($model, 'campaign_id_new')->textInput(['readonly' => isset($model->campaign_id_new) ? true : false]) ?>
        <?= $form->field($model, 'discount')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'status')->hiddenInput(['value' => isset($model->campaign_id_new) ? 0 : 2])->label(false) ?>
        <div class="form-group field-financededuction-start_date">
            <?php
            echo '<label class="control-label">Start Date</label>';
            echo DateTimePicker::widget([
                'name' => 'RedirectLog[start_time]',
                'value' => isset($model->start_time) ? gmdate('Y-m-d H:i',$model->start_time + 8*3600) : gmdate('Y-m-d H:i',time() + 8*3600),
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd hh:ii',
                    'todayHighlight' => true
                ]
            ]);
            echo '<label class="control-label">End Date</label>';
            echo DateTimePicker::widget([
                'name' => 'RedirectLog[end_time]',
                'value' => empty($model->end_time) ? '':gmdate('Y-m-d H:i',$model->end_time + 8*3600),
                'pluginOptions' => [
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd hh:ii',
                    'todayHighlight' => true
                ]
            ]);
            ?>
            <div class="help-block"></div>
        </div>
        <div class="form-group">
            <?= Html::submitButton(isset($model->campaign_id_new) ? 'Turn Off' : 'Turn On', ['class' => isset($model->campaign_id_new) ? 'btn btn-primary' : 'btn  btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
<?php
$this->registerJsFile('@web/js/redirect.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]);
?>