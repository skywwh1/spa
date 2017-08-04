<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\System */

$this->title = 'Create System';
$this->params['breadcrumbs'][] = ['label' => 'Systems', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="system-create"></div>
<div class="system-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
