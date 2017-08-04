<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\System */

$this->title = 'Update System: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Systems', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="system-index"></div>
<div class="system-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
