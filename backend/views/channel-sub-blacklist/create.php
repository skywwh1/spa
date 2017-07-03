<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\ChannelSubBlacklist */

$this->title = 'Create Channel Sub Blacklist';
$this->params['breadcrumbs'][] = ['label' => 'Channel Sub Blacklists', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div id="nav-menu" data-menu="channel-sub-blacklist-index"></div>

<div class="channel-sub-blacklist-create">


    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
