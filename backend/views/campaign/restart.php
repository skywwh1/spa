<?php

use backend\assets\AdminAsset;
use kartik\date\DatePicker;
use kartik\datetime\DateTimePicker;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

AdminAsset::register($this);
/* @var $this yii\web\View */
/* @var $model common\models\Campaign */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $form = ActiveForm::begin(['id' => 'restart-form',]); ?>
    <div class="form-group">
        <?php
        echo '<label class="control-label">Promote Start</label>';
        echo DatePicker::widget([
            'name' => 'Campaign[promote_start]',
            'type' => DatePicker::TYPE_INPUT,
            'value' => isset($model->promote_start) ? date("Y-m-d", $model->promote_start) : '',
            'pluginOptions' => [
                'autoclose' => true,
                'format' => 'yyyy-mm-dd'
            ]
        ]);
        ?>
    </div>
    <div class="form-group">
        <?= Html::button('Restart', ['class' => 'btn btn-success', 'id' => 'restart-button']) ?>
    </div>
<?php ActiveForm::end(); ?>
<?php
$js = <<< JS
$(document).on("click", "#restart-button", function (e) {
        var form = $('#restart-form')
        var url = form.attr('action');
        $.ajax({
               type: "POST",
               url: url,
               data: form.serialize(), // serializes the form's elements.
               success: function(data)
               {
                   if(data == 'success'){
                        $('#campaign-update-modal').modal('hide');
                         location.reload();
                   }else{
                     alert(data);
                   }
               }
             });
        e.preventDefault(); // a
    });
JS;
$this->registerJs($js);
?>