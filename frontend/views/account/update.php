<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Channel */

$this->title = 'Update Channel: ';

?>
<div id="nav-menu" data-menu="channel-index"></div>
<div class="channel-update">

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
