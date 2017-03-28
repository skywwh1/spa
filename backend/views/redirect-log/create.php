<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\RedirectLog */

$this->title = 'Create Redirect Log';
$this->params['breadcrumbs'][] = ['label' => 'Redirect Logs', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="redirect-log-create"></div>
<div class="redirect-log-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
