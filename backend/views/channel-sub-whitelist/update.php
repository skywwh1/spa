<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ChannelSubWhitelist */

$this->title = 'Update Channel Sub Whitelist: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Channel Sub Whitelists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="channel-sub-whitelist-index"></div>
<div class="channel-sub-whitelist-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
