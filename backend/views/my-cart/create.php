<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\MyCart */

$this->title = 'Create My Cart';
$this->params['breadcrumbs'][] = ['label' => 'My Carts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="my-cart-create"></div>
<div class="my-cart-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
