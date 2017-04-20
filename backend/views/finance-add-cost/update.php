<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\FinanceAddCost */

$this->title = 'Update Finance Add Cost: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Finance Add Costs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="finance-add-cost-index"></div>
<div class="finance-add-cost-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
