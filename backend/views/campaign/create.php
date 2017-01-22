<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Campaign */

$this->title = 'Create Campaign';
$this->params['breadcrumbs'][] = ['label' => 'Campaigns', 'url' => ['index']];
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
