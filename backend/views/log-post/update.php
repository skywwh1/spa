<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\LogPost */

$this->title = 'Update Log Post: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Log Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="log-post-index"></div>
<div class="log-post-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
