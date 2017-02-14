<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\CampaignStsUpdate */

$this->title = 'Create Campaign Sts Update';
$this->params['breadcrumbs'][] = ['label' => 'Campaign Sts Updates', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="campaign-sts-update-create"></div>
<div class="campaign-sts-update-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
