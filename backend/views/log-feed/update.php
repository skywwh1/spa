<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LogFeed */

$this->title = 'Update Log Feed: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log Feeds', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="log-feed-index"></div>
<div class="log-feed-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
