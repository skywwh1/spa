<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ChannelQualityReport */

$this->title = 'Update Channel Quality Report: ' . $model->campaign_id;
$this->params['breadcrumbs'][] = ['label' => 'Channel Quality Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->campaign_id, 'url' => ['view', 'campaign_id' => $model->campaign_id, 'channel_id' => $model->channel_id, 'sub_channel' => $model->sub_channel, 'time' => $model->time]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="channel-quality-report-index"></div>
<div class="channel-quality-report-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
