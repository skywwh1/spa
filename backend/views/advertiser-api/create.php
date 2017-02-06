<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AdvertiserApi */

$this->title = 'Create Advertiser Api';
$this->params['breadcrumbs'][] = ['label' => 'Advertiser Apis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="advertiser-api-index"></div>
<div class="advertiser-api-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
