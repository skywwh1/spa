<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\FinanceAdvertiserPrepayment */

$this->title = 'Update Finance Advertiser Prepayment: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Finance Advertiser Prepayments', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="finance-advertiser-prepayment-index"></div>
<div class="finance-advertiser-prepayment-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
