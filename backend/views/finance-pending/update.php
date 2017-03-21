<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\FinancePending */

$this->title = 'Update Finance Pending: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Finance Pendings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="finance-pending-index"></div>
<div class="finance-pending-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
