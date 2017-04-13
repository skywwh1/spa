<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\FinanceAdvertiserBillTerm */

$this->title = 'Update Finance Advertiser Bill Month: ' . $model->adv_id;
$this->params['breadcrumbs'][] = ['label' => 'Finance Advertiser Bill Months', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->adv_id, 'url' => ['view', 'adv_id' => $model->adv_id, 'start_time' => $model->start_time, 'end_time' => $model->end_time]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="finance-advertiser-bill-month-index"></div>
<div class="finance-advertiser-bill-month-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
