<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CampaignSubChannelLogRedirect */

$this->title = 'Create';
$this->params['breadcrumbs'][] = ['label' => 'Campaign Sub Channel Log Redirects', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="campaign-sub-channel-log-redirect-create"></div>
<div class="campaign-sub-channel-log-redirect-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
