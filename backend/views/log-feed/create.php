<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\LogFeed */

$this->title = 'Create Log Feed';
$this->params['breadcrumbs'][] = ['label' => 'Log Feeds', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="log-feed-create"></div>
<div class="log-feed-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
