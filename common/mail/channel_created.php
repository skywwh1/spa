<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $channel common\models\Channel */

?>
<div class="password-reset">
    <p>Welcome <?= Html::encode($channel->username) ?>,</p>

    <p>Thank you for registering a SuperADS publisher account.</p>
    <p>An account manager will contact you soon.</p>
    <p>Notice: This email is non-reply. If you have any questions about getting started, please contact service@superads.cn </p>
<!--    <p>please login in SuperADS --><?//= Html::a('Home ', 'http://www.superads.cn/site/login') ?><!-- to reset your password</p>-->
<!--    <p>Notice : This email is none reply, if any question please contact service@superads.cn</p>-->
    <p>Great to have you,</p>
    <p>The SuperADS Team</p>
</div>
