<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\CampaignStsUpdate */

$this->title = 'Update Campaign Sts Update: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Campaign Sts Updates', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="campaign-sts-update-index"></div>
<div class="campaign-sts-update-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
