<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CampaignLogSubChannelHourly */

$this->title = 'Create Campaign Log Sub Channel Hourly';
$this->params['breadcrumbs'][] = ['label' => 'Campaign Log Sub Channel Hourlies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="campaign-log-sub-channel-hourly-create"></div>
<div class="campaign-log-sub-channel-hourly-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
