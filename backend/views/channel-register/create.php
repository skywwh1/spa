<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ChannelRegister */

$this->title = 'Create Channel Register';
$this->params['breadcrumbs'][] = ['label' => 'Channel Registers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="channel-register-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
