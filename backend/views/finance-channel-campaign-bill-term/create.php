<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\FinanceChannelCampaignBillTerm */

$this->title = 'Create Finance Channel Campaign Bill Term';
$this->params['breadcrumbs'][] = ['label' => 'Finance Channel Campaign Bill Terms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="finance-channel-campaign-bill-term-create"></div>
<div class="finance-channel-campaign-bill-term-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
