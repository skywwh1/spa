<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\grid\GridView;
//var_dump($aa);
//die();
/* @var $this yii\web\View */
/* @var $model backend\models\FinanceChannelBillTerm */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Basic Info</h3>
            </div>

            <?php $form = ActiveForm::begin([
                'options' => ['class' => 'form-horizontal'],
            ]); ?>
            <div class="box-body">

                <?= $form->field($model, 'bill_id', [
                    'labelOptions' => ['class' => 'col-sm-2 control-label'],
                    'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                ])->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'invoice_id', [
                    'labelOptions' => ['class' => 'col-sm-2 control-label'],
                    'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                ])->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'period', [
                    'labelOptions' => ['class' => 'col-sm-2 control-label'],
                    'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                ])->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'channel_id', [
                    'labelOptions' => ['class' => 'col-sm-2 control-label'],
                    'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                ])->textInput() ?>
                <?= $form->field($model, 'time_zone', [
                    'labelOptions' => ['class' => 'col-sm-2 control-label'],
                    'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                ])->textInput(['maxlength' => true]) ?>
                <?= $form->field($model, 'status', [
                    'labelOptions' => ['class' => 'col-sm-2 control-label'],
                    'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                ])->textInput() ?>
                <?= $form->field($model, 'update_time', [
                    'labelOptions' => ['class' => 'col-sm-2 control-label'],
                    'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                ])->textInput() ?>
                <?= $form->field($model, 'note', [
                    'labelOptions' => ['class' => 'col-sm-2 control-label'],
                    'template' => "{label}<div class='col-sm-5'>{input}</div>{hint}\n{error}",
                ])->textarea(['rows' => 6]) ?>

            </div>

            <div class="box-footer">
                <?= Html::submitButton('Commit', ['class' => 'btn btn-primary']) ?>
            </div>
            <?php ActiveForm::end(); ?>

        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <div class="box box-info">

        </div>
    </div>
</div>
