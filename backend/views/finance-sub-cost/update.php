<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\FinanceSubCost */

$this->title = 'Update Finance Sub Cost: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Finance Sub Costs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="finance-sub-cost-index"></div>
<div class="finance-sub-cost-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
