<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\FinanceAdvertiserCampaignBillTerm */

$this->title = 'Create Finance Advertiser Campaign Bill Term';
$this->params['breadcrumbs'][] = ['label' => 'Finance Advertiser Campaign Bill Terms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="finance-advertiser-campaign-bill-term-create"></div>
<div class="finance-advertiser-campaign-bill-term-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
