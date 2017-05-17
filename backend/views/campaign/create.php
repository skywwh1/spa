<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model common\models\Campaign */

$this->title = 'Create Offer';
$this->params['breadcrumbs'][] = ['label' => 'Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="row">

    <div id="nav-menu" data-menu="campaign_create"></div>

    <?= $this->render('_form', [
        'model' => $model,
        'modelsLink' => $modelsLink
    ]) ?>

</div>