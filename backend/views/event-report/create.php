<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\LogEventHourly */

$this->title = 'Create Log Event Hourly';
$this->params['breadcrumbs'][] = ['label' => 'Log Event Hourlies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="log-event-hourly-create"></div>
<div class="log-event-hourly-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
