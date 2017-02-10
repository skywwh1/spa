<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Stream */

$this->title = 'Create Stream';
$this->params['breadcrumbs'][] = ['label' => 'Streams', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="stream-create"></div>
<div class="stream-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
