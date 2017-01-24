<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Deliver */

$this->title = 'Create Deliver';
$this->params['breadcrumbs'][] = ['label' => 'Delivers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="deliver-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
