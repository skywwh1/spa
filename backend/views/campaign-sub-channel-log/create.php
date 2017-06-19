<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CampaignSubChannelLog */

$this->title = 'Create Campaign Sub Channel Log';
$this->params['breadcrumbs'][] = ['label' => 'Campaign Sub Channel Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="campaign-sub-channel-log-create"></div>
<div class="campaign-sub-channel-log-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
