<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Advertiser */

$this->title = 'Create Advertiser';
$this->params['breadcrumbs'][] = ['label' => 'Advertisers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="col-lg-12">
    <div class="box box-info">
        <div class="box-body">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

        </div>
    </div>
</div>
