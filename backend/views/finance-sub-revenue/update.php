<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\FinanceSubRevenue */

$this->title = 'Update Finance Sub Revenue: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Finance Sub Revenues', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="finance-sub-revenue-index"></div>
<div class="finance-sub-revenue-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
