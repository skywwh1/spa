<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\FinanceDeduction */

$this->title = 'Update Finance Deduction: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Finance Deductions', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="finance-deduction-index"></div>
<div class="finance-deduction-update">

    <div class="row">
        <div class="col-lg-6">
            <div class="box box-info">
                <div class="box-body">
                    <div class="finance-deduction-form">

                        <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'id')->hiddenInput()->label(false) ?>

                        <?= $form->field($model, 'status')->dropDownList(ModelsUtil::deduction_status) ?>
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
            </div>
        </div>
    </div>

</div>
