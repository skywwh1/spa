<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\AdvertiserApi */

$this->title = 'Create Advertiser Api';
$this->params['breadcrumbs'][] = ['label' => 'Advertiser Apis', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>


<?= $this->render('_form', [
    'model' => $model,
]) ?>


