<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Advertiser */

$this->title = 'Create Advertiser';
$this->params['breadcrumbs'][] = ['label' => 'Advertisers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="advertiser_create"></div>
<div class="row">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
