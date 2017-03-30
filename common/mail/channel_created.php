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
    <p>password: <?= $channel->password_hash?></p>
    <p>please login in SuperADS <?= Html::a('Home ', 'http://www.superads.cn/site/login') ?> to reset your password</p>
    <p>Notice : This email is none reply, if any question please contact service@superads.cn</p>
</div>
