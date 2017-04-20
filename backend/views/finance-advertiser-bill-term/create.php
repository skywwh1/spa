<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\FinanceAdvertiserBillTerm */

$this->title = 'Create Finance Advertiser Bill Term';
$this->params['breadcrumbs'][] = ['label' => 'Finance Advertiser Bill Terms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="finance-advertiser-bill-term-create"></div>
<div class="finance-advertiser-bill-term-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
