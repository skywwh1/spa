<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CampaignSubChannelLogRedirect */

$this->title = 'Update Campaign Sub Channel Log Redirect: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Campaign Sub Channel Log Redirects', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="campaign-sub-channel-log-redirect-index"></div>
<div class="campaign-sub-channel-log-redirect-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
