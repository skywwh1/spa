<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\IpTable */

$this->title = 'Create Ip Table';
$this->params['breadcrumbs'][] = ['label' => 'Ip Tables', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="ip-table-index"></div>
<div class="ip-table-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
