<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ApiCampaign */

$this->title = 'Create Api Campaign';
$this->params['breadcrumbs'][] = ['label' => 'Api Campaigns', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="api-campaign-create"></div>
<div class="api-campaign-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
