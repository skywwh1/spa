<?php

use yii\redactor\widgets\Redactor;
use kartik\datetime\DateTimePicker;
use yii\helpers\HtmlPurifier;

/* @var $this yii\web\View */
/* @var $model common\models\EmailContent */
/* @var $form yii\widgets\ActiveForm */

?>
<h3>History Email</h3>
<?php
    if (!is_null($model)) {
    $i = 0;
    foreach ($model as $deliver) {
    ?>
        <div class="box box-info">
            <div class="box-header with-border">
                <h3 class="box-title">Offer <?= $deliver->campaign->campaign_name ?> to <?= $deliver->channel->username ?></h3>
                <span><?=date('Y-m-d',$deliver->create_time); ?></span>
            </div>
            <div class="box-body">
                <div class="post">
                    <?= HtmlPurifier::process($deliver->content) ?>
                </div>
            </div>
        </div>
<?php
$i++;
}
}