<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\FinanceChannelBillTerm */

$this->title = 'Create Finance Channel Bill Term';
$this->params['breadcrumbs'][] = ['label' => 'Finance Channel Bill Terms', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="finance-channel-bill-term-create"></div>
<div class="finance-channel-bill-term-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
