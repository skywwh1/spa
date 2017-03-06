<?php

use backend\assets\AdminAsset;
use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

AdminAsset::register($this);
/* @var $this yii\web\View */
/* @var $model common\models\Campaign */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['id' => 'restart-form',]); ?>
<?= $form->field($model, 'promote_end')->widget(DateTimePicker::classname(), [
    'type' => DateTimePicker::TYPE_INPUT,
    'value' => isset($model->promote_end) ? date("Y-m-d h:i", $model->promote_start) : '',
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'yyyy-mm-dd hh:ii',
//        'startDate' => date('Y-m-d h:i', strtotime("+1 day"))
    ],
    'readonly' => true,
]);
?>
    <div class="form-group">
        <?= Html::button('Restart', ['class' => 'btn btn-success', 'id' => 'aaa']) ?>
    </div>
<?php ActiveForm::end(); ?>
<?php
$js = <<< JS
    $('#aaa').click(function(){
        var form = $('#restart-form')
        var url = form.attr('action');
        $.ajax({
               type: "POST",
               url: url,
               data: form.serialize(), // serializes the form's elements.
               success: function(data)
               {
                   if(data == 'success'){
                   }
                        $('#campaign-modal').modal('hide');
               }
             });
        e.preventDefault(); // a
    });
JS;
$this->registerJs($js);
?>