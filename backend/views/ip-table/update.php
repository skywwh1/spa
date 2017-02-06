<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\IpTable */

$this->title = 'Update Ip Table: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Ip Tables', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="ip-table-index"></div>
<div class="ip-table-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
