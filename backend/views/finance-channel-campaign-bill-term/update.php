<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\FinanceChannelCampaignBillTerm */

$this->title = 'Update Finance Channel Campaign Bill Term: ' . $model->bill_id;
$this->params['breadcrumbs'][] = ['label' => 'Finance Channel Campaign Bill Terms', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->bill_id, 'url' => ['view', 'bill_id' => $model->bill_id, 'campaign_id' => $model->campaign_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="finance-channel-campaign-bill-term-index"></div>
<div class="finance-channel-campaign-bill-term-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
