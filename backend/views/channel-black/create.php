<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ChannelBlack */

$this->title = 'Create Channel Black';
$this->params['breadcrumbs'][] = ['label' => 'Channel Blacks', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="channel-black-index"></div>
<div class="channel-black-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
