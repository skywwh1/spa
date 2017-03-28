<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\RedirectLog */

$this->title = 'Update Redirect Log: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Redirect Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="redirect-log-index"></div>
<div class="redirect-log-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
