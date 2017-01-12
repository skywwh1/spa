<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\S2s */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="s2s-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class='form-group row'>
        <div class='col-lg-4'>
            <?= $form->field($model, 'campaign_uuid')->textInput() ?>
        </div>
    </div>

 <div class='form-group row'>
   <div class='col-lg-4'>
    <?= $form->field($model, 'channel0')->textInput() ?>
   </div>
 </div>
            <?= $form->field($model, 'first_step')->hiddenInput(['value'=>1])->label(false)?>
    <?php
//    echo AutoComplete::widget([
//        'model' => $model,
//        'attribute' => 'country',
//        'clientOptions' => [
//            'source' => ['USA', 'RUS'],
//        ],
//    ]);
    ?>
    <div class="form-group">
        <?= Html::submitButton('Go ahead', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>
    <div id="test_div"></div>
</div>
