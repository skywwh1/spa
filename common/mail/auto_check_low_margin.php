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

    <p>&nbsp;&nbsp; &nbsp;The margin for the following channels are low, here’re actions made:</p>

    <table border="1">
        <tbody>
        <?php
        $id = '<td width="100px"> ID</td>';
        $campaign_name = '<td> Campaign name</td>';
        $channel = '<td> Channel</td>';
        $match_cvr = '<td>Match CVR</td>';
        $revenue = '<td>Revenue</td>';
        $margin = '<td> Margin</td>';
        $action = '<td> Action</td>';


        foreach ($checks as $check) {
            $id .= '<td>' . Html::encode($check->campaign_id) . '</td>';
            $campaign_name .= '<td width="130px">' . Html::encode($check->campaign_name) . '</td>';
            $channel .= '<td>' . Html::encode($check->channel_name) . '</td>';
            $match_cvr .= '<td>' . Html::encode($check->match_cvr) . '</td>';
            $revenue .= '<td>' . Html::encode($check->revenue) . '</td>';
            $margin .= '<td>' . Html::encode($check->margin) . '</td>';
            $action .= '<td>' . Html::encode($check->action) . '</td>';
        }

        $id = '<tr>' . $id . '</tr>';
        $campaign_name = '<tr>' . $campaign_name . '</tr>';
        $channel = '<tr>' . $channel . '</tr>';
        $match_cvr = '<tr>' . $match_cvr . '</tr>';
        $revenue = '<tr>' . $revenue . '</tr>';
        $margin = '<tr>' . $margin . '</tr>';
        $action = '<tr>' . $action . '</tr>';

        echo $id;
        echo $campaign_name;
        echo $channel;
        echo $match_cvr;
        echo $revenue;
        echo $margin;
        echo $action;

        ?>
        </tbody>
    </table>
    <p>&nbsp;&nbsp; &nbsp;Please check the details and take needed actions accordingly.</p>
    <p>If you have any problem, pls feel free to contact tech team: tech@superads.cn</p>
    <p>Have a nice day. </p>
    <p>Best regards</p>
    <p>SuperADS Support Team</p>
</div>
