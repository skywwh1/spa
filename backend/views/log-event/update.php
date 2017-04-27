<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LogEvent */

$this->title = 'Update Log Event: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="log-event-index"></div>
<div class="log-event-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
