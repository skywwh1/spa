<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ChannelSubWhitelist */

$this->title = 'Create Channel Sub Whitelist';
$this->params['breadcrumbs'][] = ['label' => 'Channel Sub Whitelists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="channel-sub-whitelist-create"></div>
<div class="channel-sub-whitelist-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
