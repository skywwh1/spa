<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ChannelSubBlacklist */

$this->title = 'Update Channel Sub Blacklist: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Channel Sub Blacklists', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="channel-sub-blacklist-index"></div>

<div class="channel-sub-blacklist-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
