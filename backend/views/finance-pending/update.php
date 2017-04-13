<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\FinancePending */

$this->title = 'Update Finance Pending: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Finance Pendings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>

<div class="row">
    <div class="col-lg-12">

        <?php $form = ActiveForm::begin([
            'id' => 'update-form',
        ]); ?>

        <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>
        <?= $form->field($model, 'status')->dropDownList(ModelsUtil::pending_status) ?>
        <?= $form->field($model, 'note')->textarea(['rows' => 6]) ?>
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord
                ? 'Create' : 'Update', ['class' => $model->isNewRecord ? 'btn
                        btn-success' :
                'btn btn-primary']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
