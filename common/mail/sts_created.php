<?php
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $deliver common\models\Deliver */

?>
<div class="password-reset">
    <p>Hello <?= Html::encode($deliver->channel->username) ?>,</p>

    <p>Follow the track link below </p>

    <p><?= Html::a(Html::encode($resetLink), $resetLink) ?></p>
</div>
