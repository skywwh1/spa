<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\FinanceChannelPrepayment */

$this->title = 'Update Finance Apply Prepayment: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Finance Apply Prepayments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="finance-apply-prepayment-index"></div>
<div class="finance-apply-prepayment-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
