<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Channel */

$this->title = 'Create Channel';
$this->params['breadcrumbs'][] = ['label' => 'Channels', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="channel-create">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
