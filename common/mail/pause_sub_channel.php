<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $sub_log common\models\CampaignSubChannelLog */
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

    <h4>Dear <?php
        $channel = $sub_log->channel;
        if (!empty($channel->contacts)) {
            echo Html::encode($channel->contacts);
        } else {
            echo Html::encode($channel->username);
        } ?>:</h4>

    <p>&nbsp;&nbsp; &nbsp;Hope this email finds you well.</p>

    <p>&nbsp;&nbsp; &nbsp;Please pause the following sub publisher due to low quality.</p>

    <table border="1">
        <tbody>
        <?php
        $id = '<td width="100px"> ID</td>';
        $campaign_name = '<td> Campaign name</td>';
        $version = '<td> OS</td>';
        $target_geo = '<td> Target Geo</td>';
        $preview_link = '<td>Preview Link</td>';
        $sub_channel = '<td> Sub Channel</td>';
        $new = '<td><b>Pausing Time(GMT+8)</b></td>';


        $id .= '<td>' . Html::encode($sub_log->campaign->id) . '</td>';
        $campaign_name .= '<td width="130px">' . Html::encode($sub_log->campaign->campaign_name) . '</td>';
        $version .= '<td>' . Html::encode($sub_log->campaign->platform) . '</td>';
        $target_geo .= '<td>' . Html::encode($sub_log->campaign->target_geo) . '</td>';
        $preview_link .= '<td><a href="' . Html::encode($sub_log->campaign->preview_link) . '">Preview Link</a></td>';
        $sub_channel .= '<td style="background-color:yellow">' . Html::encode($sub_log->sub_channel) . '</td>';
        $new .= '<td style="background-color:yellow">' . Html::encode(date('Y-m-d H:i', $sub_log->effect_time)) . '</td>';

        $id = '<tr>' . $id . '</tr>';
        $campaign_name = '<tr>' . $campaign_name . '</tr>';
        $version = '<tr>' . $version . '</tr>';
        $target_geo = '<tr>' . $target_geo . '</tr>';
        $preview_link = '<tr>' . $preview_link . '</tr>';
        $sub_channel = '<tr>' . $sub_channel . '</tr>';
        $new = '<tr>' . $new . '</tr>';

        echo $id;
        echo $campaign_name;
        echo $version;
        echo $target_geo;
        echo $preview_link;
        echo $sub_channel;
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
