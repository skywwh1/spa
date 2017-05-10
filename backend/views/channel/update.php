<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Channel */

$this->title = 'Update Channel: ' . $model->username;
$this->params['breadcrumbs'][] = ['label' => 'Channels', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="my_channels"></div>

<?= $this->render('_form', [
    'model' => $model,
]) ?>
