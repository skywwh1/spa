<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\FinanceCompensation */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Finance Compensations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <div id="nav-menu" data-menu="finance-compensation-view"></div>
    <div class="col-lg-12">
        <div class="box box-info">
            <div class="box-body">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'deduction_id',
            'system_cost',
            'system_revenue',
            'billable_cost',
            'billable_revenue',
            'billable_margin',
            'compensation',
            'final_margin',
            'status',
        ],
    ]) ?>

            </div>
        </div>
    </div>
</div
