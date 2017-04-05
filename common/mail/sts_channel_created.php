<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $delivers common\models\Deliver[] */
/* @var $channel common\models\Channel */

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

    <h4>Dear <?php if (!empty($channel->contacts)) {
            echo Html::encode($channel->contacts);
        } else {
            echo Html::encode($channel->username);
        } ?>:</h4>

    <p>&nbsp;&nbsp; &nbsp;Hope this email finds you well.</p>

    <p>&nbsp;&nbsp; &nbsp;Here are some new campaigns for you today. Please kindly set live and start sending good
        traffic on them.</p>

    <table border="1">
        <tbody>
        <?php
        $id = '<td width="100px"> ID</td>';
        $campaign_name = '<td> Campaign name</td>';
        $version = '<td> OS </td>';
        $target_geo = '<td> Target Geo</td>';
        $payout = '<td> Payout</td>';
        $preview_link = '<td>Preview Link</td>';
        $link = '<td> Link</td>';
        $creative = '<td> Creative</td>';
        $traffic_source = '<td> Traffic Source</td>';
        $daily_cap = '<td> Daily Cap</td>';
        $notes = '<td> Notes</td>';
        $conversion_flow = '<td> Conversion Flow</td>';
        $carrier = '<td> Carrier</td>';

        foreach ($delivers as $deliver) {
            $id .= '<td>' . Html::encode($deliver->campaign->id) . '</td>';
            $campaign_name .= '<td width="130px">' . Html::encode($deliver->campaign->campaign_name) . '</td>';
            $version .= '<td>' . Html::encode($deliver->campaign->platform) . '</td>';
            $target_geo .= '<td>' . Html::encode($deliver->campaign->target_geo) . '</td>';
            $payout .= '<td>' . Html::encode($deliver->pay_out) . '</td>';
            $preview_link .= '<td><a href="' . Html::encode($deliver->campaign->preview_link) . '">Preview Link</a></td>';
            $link .= '<td><a href="' . Url::to('@track' . $deliver->track_url) . '">Tracking Link</a></td>';
            $creativeSet = !empty($deliver->campaign->creative_link) ? '<a href="' . Url::to($deliver->campaign->creative_link) . '">Banner</a>' : '';
            $creative .= '<td>' . $creativeSet . '</td>';
            $traffic_source .= '<td>' . $deliver->campaign->traffic_source . '</td>';
            $daily_cap .= '<td>' . Html::encode($deliver->daily_cap) . '</td>';
            $notes .= '<td width="130px">' . Html::encode($deliver->note) . '</td>';
            $conversion_flow .= '<td>' . Html::encode($deliver->campaign->conversion_flow) . '</td>';
            $carrier .= '<td>' . Html::encode($deliver->campaign->carriers) . '</td>';
        }

        $id = '<tr>' . $id . '</tr>';
        $campaign_name = '<tr>' . $campaign_name . '</tr>';
        $version = '<tr>' . $version . '</tr>';
        $target_geo = '<tr>' . $target_geo . '</tr>';
        $payout = '<tr>' . $payout . '</tr>';
        $preview_link = '<tr>' . $preview_link . '</tr>';
        $link = '<tr>' . $link . '</tr>';
        $creative = '<tr>' . $creative . '</tr>';
        $traffic_source = '<tr>' . $traffic_source . '</tr>';
        $daily_cap = '<tr>' . $daily_cap . '</tr>';
        $notes = '<tr>' . $notes . '</tr>';
        //            $exclude_traffic = '<tr>' . $exclude_traffic . '</tr>';
        $conversion_flow = '<tr>' . $conversion_flow . '</tr>';
        $carrier = '<tr>' . $carrier . '</tr>';

        echo $id;
        echo $campaign_name;
        echo $version;
        echo $target_geo;
        echo $payout;
        echo $preview_link;
        echo $link;
        echo $creative;
        echo $traffic_source;
        echo $daily_cap;
        echo $notes;
        //            echo $exclude_traffic;
        echo $conversion_flow;
        echo $carrier;

        ?>
        </tbody>
    </table>
    <p>&nbsp;&nbsp; &nbsp;Note:&nbsp;This email&nbsp;is a <strong>NO-REPLY</strong> email. If you need any help, please
        feel free to contact your beloved account managers.</p>
    <p>Have a nice day. </p>
    <p>Best regards</p>
    <p>SuperADS Support Team</p>
</div>
