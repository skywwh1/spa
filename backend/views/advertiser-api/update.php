<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\AdvertiserApi */

$this->title = 'Update Advertiser Api: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Advertiser Apis', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="advertiser-api-index"></div>
<div class="advertiser-api-update">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
