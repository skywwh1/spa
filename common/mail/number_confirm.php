<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $channel common\models\Advertiser */

?>
<div class="password-reset">
    <h4>Dear <?php
        if (!empty($advertiser->contacts)) {
            echo Html::encode($advertiser->contacts);
        } else {
            echo Html::encode($advertiser->username);
        } ?>:</h4>

    <p>Hope this e-mail finds you well.</p>
    <p>We are kindly reminding you that according to our agreement, all numbers must be confirmed before the 15th, after the 15th no changes in amounts will be made, and all numbers will be confirmed with our publishers according to your statistics/platform.</p>
    <p>Please, confirm the numbers for Last month.</p>
    <p>Let's finish this boring task and continue making money together =)</p>
    <p>If you have confirmed the numbers of last month, please neglect this email. Sorry for the disturbance.</p>
    <p>Best regards,</p>
    <p>Your SuperADS team</p>
</div>
