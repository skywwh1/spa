<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LogEventHourly */

$this->title = 'Update Log Event Hourly: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log Event Hourlies', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="log-event-hourly-index"></div>
<div class="log-event-hourly-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
