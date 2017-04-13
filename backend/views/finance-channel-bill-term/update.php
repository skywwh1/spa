<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\FinanceChannelBillTerm */

$this->title = 'Update Finance Channel Bill Term: ' . $model->bill_id;
$this->params['breadcrumbs'][] = ['label' => 'Finance Channel Bill Terms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->bill_id, 'url' => ['view', 'id' => $model->bill_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="finance-channel-bill-term-index"></div>
<div class="finance-channel-bill-term-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
