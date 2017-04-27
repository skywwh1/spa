<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\LogEvent */

$this->title = 'Create Log Event';
$this->params['breadcrumbs'][] = ['label' => 'Log Events', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="log-event-create"></div>
<div class="log-event-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
