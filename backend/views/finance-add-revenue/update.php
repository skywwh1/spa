<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\FinanceAddRevenue */

$this->title = 'Update Finance Add Revenue: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Finance Add Revenues', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="finance-add-revenue-index"></div>
<div class="finance-add-revenue-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
