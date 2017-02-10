<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ApiCampaign */

$this->title = 'Update Api Campaign: ' . $model->adv_id;
$this->params['breadcrumbs'][] = ['label' => 'Api Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->adv_id, 'url' => ['view', 'adv_id' => $model->adv_id, 'campaign_id' => $model->campaign_id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="api-campaign-index"></div>
<div class="api-campaign-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
