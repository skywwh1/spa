<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\FinancePending */

$this->title = 'Add ADV Pending';
$this->params['breadcrumbs'][] = ['label' => 'Finance Pending', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="finance-pending-create"></div>
<div class="finance-pending-create">


    <?= $this->render('adv_pending_form', [
        'model' => $model,
    ]) ?>

</div>
