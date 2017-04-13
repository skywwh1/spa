<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\FinanceCompensation */

$this->title = 'Update Finance Compensation: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Finance Compensations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="row">
    <div class="col-lg-12">

        <?php $form = ActiveForm::begin([
            'id' => 'update-form',
        ]); ?>

        <?= $form->field($model, 'status')->dropDownList(ModelsUtil::compensation_status) ?>
        <?= $form->field($model, 'note')->textarea(['value'=>$model->id0->note]) ?>
        <div class="form-group">
            <?= Html::submitButton('Update', ['class' => 'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>
</div>
