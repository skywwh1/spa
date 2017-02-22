<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $deliver common\models\Deliver */

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
        text-align: center;
        border: 1px solid #ddd
    }
</style>
<div class="sts_created" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">

    <h4>Dear <?= Html::encode($deliver->channel->username) ?>:</h4>

    <p>&nbsp;&nbsp; &nbsp;Hope this email finds you well.</p>

    <p>&nbsp;&nbsp; &nbsp;Please kindly check the following latest offer
        updates and make the changes accordingly.</p>

    <table border="1">
        <tbody>
        <?php
        $id = '<td width="100px"> ID</td>';
        $campaign_name = '<td> Campaign name</td>';
        $version = '<td> OS</td>';
        $target_geo = '<td> Target Geo</td>';
        $preview_link = '<td>Preview Link</td>';
        $link = '<td> Link</td>';
        $new = '<td><b>Pausing Time(GMT+8)</b></td>';


        $id .= '<td>' . Html::encode($deliver->campaign->id) . '</td>';
        $campaign_name .= '<td width="130px">' . Html::encode($deliver->campaign->campaign_name) . '</td>';
        $version .= '<td>' . Html::encode($deliver->campaign->platform) . '</td>';
        $target_geo .= '<td>' . Html::encode($deliver->campaign->target_geo) . '</td>';
        $preview_link .= '<td><a href="' . Html::encode($deliver->campaign->preview_link) . '">Preview Link</a></td>';
        $link .= '<td><a href="' . Url::to('@track' . $deliver->track_url) . '">Tracking Link</a></td>';
        $new .= '<td style="background-color:yellow">' . Html::encode(date('Y-m-d H:i', $deliver->effect_time)) . '</td>';

        $id = '<tr>' . $id . '</tr>';
        $campaign_name = '<tr>' . $campaign_name . '</tr>';
        $version = '<tr>' . $version . '</tr>';
        $target_geo = '<tr>' . $target_geo . '</tr>';
        $preview_link = '<tr>' . $preview_link . '</tr>';
        $link = '<tr>' . $link . '</tr>';
        $new = '<tr>' . $new . '</tr>';

        echo $id;
        echo $campaign_name;
        echo $version;
        echo $target_geo;
        echo $preview_link;
        echo $link;
        echo $new;

        ?>
        </tbody>
    </table>
    <p>&nbsp;&nbsp; &nbsp;Note:&nbsp;This email&nbsp;is a <strong>NO-REPLY</strong> email. If you need any help, please
        feel free to contact your beloved account managers.</p>
    <p>Have a nice day. </p>
    <p>Best regards</p>
    <p>SuperADS Support Team</p>
</div>
