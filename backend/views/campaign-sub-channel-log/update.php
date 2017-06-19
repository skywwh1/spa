<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CampaignSubChannelLog */

$this->title = 'Update Campaign Sub Channel Log: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Campaign Sub Channel Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="campaign-sub-channel-log-index"></div>
<div class="campaign-sub-channel-log-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
