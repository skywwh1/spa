<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\FinanceAdvertiserBillTerm */

$this->title = 'Create Finance Advertiser Bill Month';
$this->params['breadcrumbs'][] = ['label' => 'Finance Advertiser Bill Months', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="finance-advertiser-bill-month-create"></div>
<div class="finance-advertiser-bill-month-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
