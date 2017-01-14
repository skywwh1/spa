<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $channel common\models\Channel */

?>
<div class="password-reset">
    <p>Hello <?= Html::encode($channel->username) ?>,</p>

    <p>You account have been created</p>
    <p>username: <?= $channel->username ?></p>
    <p>password: <?= $channel->password_hash ?></p>
    <p>please login in SuperADS <?= Html::a('Home ', Url::home(true)) ?> to reset your password</p>
</div>
