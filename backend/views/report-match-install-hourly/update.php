<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ReportMatchInstallHourly */

$this->title = 'Update Report Match Install Hourly: ' . $model->campaign_id;
$this->params['breadcrumbs'][] = ['label' => 'Report Match Install Hourlies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->campaign_id, 'url' => ['view', 'campaign_id' => $model->campaign_id, 'time' => $model->time]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="report-match-install-hourly-index"></div>
<div class="report-match-install-hourly-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
