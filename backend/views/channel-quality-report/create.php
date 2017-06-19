<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ChannelQualityReport */

$this->title = 'Create Channel Quality Report';
$this->params['breadcrumbs'][] = ['label' => 'Channel Quality Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="channel-quality-report-create"></div>
<div class="channel-quality-report-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
