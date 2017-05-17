<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Campaign */

$this->title = 'Update : ' . $model->campaign_name;
$this->params['breadcrumbs'][] = ['label' => 'Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->campaign_name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="row">

    <div id="nav-menu" data-menu="campaign_index"></div>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsLink' => $modelsLink
    ]) ?>
</div>
