<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $checks common\models\LogAutoCheck[] */

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

    <h4>Hi Team:</h4>

    <p>&nbsp;&nbsp; &nbsp;The following campaign reached 80% daily cap, pls ask the client to allocate more budget for us.</p>

    <table border="1">
        <tbody>
        <?php
        $id = '<td width="100px"> ID</td>';
        $campaign_name = '<td> Campaign name</td>';
        $advertiser = '<td> Advertiser</td>';
        $match_install = '<td> Match Install</td>';
        $daily_cap = '<td>Daily Cap</td>';
        $consumption = '<td>Consumption</td>';

        foreach ($checks as $check) {
            $id .= '<td>' . Html::encode($check->campaign_id) . '</td>';
            $campaign_name .= '<td width="130px">' . Html::encode($check->campaign_name) . '</td>';
            $advertiser .= '<td>' . Html::encode($check->campaign->advertiser0->username) . '</td>';
            $match_install .= '<td>' . Html::encode($check->match_install) . '</td>';
            $daily_cap .= '<td>' . Html::encode($check->daily_cap) . '</td>';
            $consumption .= '<td>' . Html::encode($check->daily_cap).'/'.Html::encode($check->match_install) . '</td>';
        }

        $id = '<tr>' . $id . '</tr>';
        $campaign_name = '<tr>' . $campaign_name . '</tr>';
        $advertiser = '<tr>' . $advertiser . '</tr>';
        $match_install = '<tr>' . $match_install . '</tr>';
        $daily_cap = '<tr>' . $daily_cap . '</tr>';
        $consumption = '<tr>' . $consumption . '</tr>';

        echo $id;
        echo $campaign_name;
        echo $advertiser;
        echo $match_install;
        echo $daily_cap;
        echo $consumption;

        ?>
        </tbody>
    </table>
    <p>&nbsp;&nbsp; &nbsp;Please check the details and take needed actions accordingly.</p>
    <p>If you have any problem, pls feel free to contact tech team: tech@superads.cn</p>
    <p>Have a nice day. </p>
    <p>Best regards</p>
    <p>SuperADS Support Team</p>
</div>
