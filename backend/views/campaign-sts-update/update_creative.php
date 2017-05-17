<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;
use wbraganca\dynamicform\DynamicFormWidget;
/* @var $this yii\web\View */
/* @var $model common\models\Campaign */

?>
    <h3>Update Creative</h3>
<?php $form = ActiveForm::begin([
    'id'=> 'dynamic-form',
]); ?>

<?= $form->field($model, 'campaign_id')->hiddenInput()->label(false) ?>

<?= $form->field($model, 'effect_time')->widget(DateTimePicker::classname(), [
    'type' => DateTimePicker::TYPE_INPUT,
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd hh:ii',
    ],
    'readonly' => true,
]);
?>
<?= $form->field($model, 'is_send')->dropDownList(['1' => 'Yes', '0' => "No"]) ?>
    <div class="padding-v-md">
        <div class="line line-dashed"></div>
    </div>

<?php DynamicFormWidget::begin([
    'widgetContainer' => 'dynamicform_wrapper',
    'widgetBody' => '.container-items',
    'widgetItem' => '.house-item',
    'limit' => 10,
    'min' => 1,
    'insertButton' => '.add-house',
    'deleteButton' => '.remove-house',
    'model' => $modelsLink[0],
    'formId' => 'dynamic-form',
    'formFields' => [
        'creative_link',
        'creative_type',
    ],
]); ?>
    <table class="table table-bordered table-striped">
        <thead>
        <tr>
            <th>Creative Links</th>
            <!--            <th style="width: 450px;">Rooms</th>-->
            <th class="text-center" style="width: 90px;">
                <button type="button" class="add-house btn btn-success btn-xs"><span class="fa fa-plus"></span></button>
            </th>
        </tr>
        </thead>
        <tbody class="container-items">
        <?php foreach ($modelsLink as $indexHouse => $modelLink): ?>
            <tr class="house-item">
                <td class="vcenter">
                    <?php
                    // necessary for update action.
                    if (! $modelLink->isNewRecord) {
                        echo Html::activeHiddenInput($modelLink, "[{$indexHouse}]id");
                    }
                    ?>
                    <?= $form->field($modelLink, "[{$indexHouse}]creative_link")->label(false)->textInput(['maxlength' => true]) ?>
                    <?= $form->field($modelLink, "[{$indexHouse}]creative_type")->dropDownList(ModelsUtil::create_type) ?>
                </td>
                <td class="text-center vcenter" style="width: 90px; verti">
                    <button type="button" class="remove-house btn btn-danger btn-xs"><span class="fa fa-minus"></span></button>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php DynamicFormWidget::end(); ?>
    <div class="form-group">
        <?= Html::submitButton('Submit', ['class' => 'btn btn-success']) ?>
    </div>
<?php $this->registerJsFile('@web/js/yii2-dynamic-form.min.js',
    ['depends' => [\yii\web\JqueryAsset::className()]]);
?>

<?php ActiveForm::end(); ?>