<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ApiCampaigns */

$this->title = 'Create Api Campaigns';
$this->params['breadcrumbs'][] = ['label' => 'Api Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="api-campaigns-create"></div>
<div class="api-campaigns-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
