<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CampaignLogSubChannelHourly */

$this->title = 'Update Campaign Log Sub Channel Hourly: ' . $model->campaign_id;
$this->params['breadcrumbs'][] = ['label' => 'Campaign Log Sub Channel Hourlies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->campaign_id, 'url' => ['view', 'campaign_id' => $model->campaign_id, 'channel_id' => $model->channel_id, 'sub_channel' => $model->sub_channel, 'time' => $model->time]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="campaign-log-sub-channel-hourly-index"></div>
<div class="campaign-log-sub-channel-hourly-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
