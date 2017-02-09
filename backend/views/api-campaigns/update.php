<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\ApiCampaigns */

$this->title = 'Update Api Campaigns: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Api Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="api-campaigns-index"></div>
<div class="api-campaigns-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
