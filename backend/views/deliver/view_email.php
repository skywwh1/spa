<?php

use yii\redactor\widgets\Redactor;
use kartik\datetime\DateTimePicker;
use yii\helpers\HtmlPurifier;

/* @var $this yii\web\View */
/* @var $model common\models\EmailContent */
/* @var $form yii\widgets\ActiveForm */

?>
    <style type="text/css">
        table {
            border-spacing: 0;
            border-collapse: collapse;
            background-color: #ffffff;
            border-color: #ccc;
            font-family: 'microsoft yahei', calibri, verdana;
            table-layout: fixed;
        }

        table tr {
            height: 30px;
            vertical-align: middle;
            font-size: 13px;
            background-color: #fefefe;
            border: 1px solid #ddd
        }

        table tr th {
            text-align: center;
            border: 1px solid #ccc
        }

        table tbody td {
            /*text-align: center;*/
            border: 1px solid #ddd
        }
    </style>
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