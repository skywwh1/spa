<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\LogPost */

$this->title = 'Create Log Post';
$this->params['breadcrumbs'][] = ['label' => 'Log Posts', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="log-post-create"></div>
<div class="log-post-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
