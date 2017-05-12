<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\MyCart */

$this->title = 'Update My Cart: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'My Carts', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div id="nav-menu" data-menu="my-cart-index"></div>
<div class="my-cart-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
