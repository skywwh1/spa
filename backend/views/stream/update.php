<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Stream */

$this->title = 'Update Stream: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Streams', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="stream-index"></div>
<div class="stream-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
