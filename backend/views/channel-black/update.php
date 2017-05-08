<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ChannelBlack */

$this->title = 'Update Channel Black: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Channel Blacks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="channel-black-index"></div>
<div class="channel-black-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
