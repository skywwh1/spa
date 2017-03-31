<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\FinanceDeduction */

$this->title = 'Create Finance Deduction';
$this->params['breadcrumbs'][] = ['label' => 'Finance Deductions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="finance-deduction-create"></div>
<div class="finance-deduction-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
