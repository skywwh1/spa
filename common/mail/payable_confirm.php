<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $campaignBills backend\models\FinanceChannelCampaignBillTerm[] */
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
//        $channel = $campaign->channel;
        echo Html::encode(Yii::$app->user->identity->username);
        ?>:</h4>
    <?php
    $period = '';
    $payable = '';
    foreach ($campaignBills as $item) {
        if (!empty($item->campaign_id)){
            $payable += $item->cost - $item->pending_cost - $item->deduction_cost;
            $period = $item->bill->period;
        }
    }
?>
    <p>&nbsp;&nbsp; &nbsp;Good day! </p>
    <?php
        echo '<p>&nbsp;&nbsp; &nbsp;Here are confirmed numbers for period:'.$period;
        echo '<p>&nbsp;&nbsp; &nbsp;Total payable amount is '.$payable.'. Pls send the invoice accordingly.</p>';
    ?>

    <table border="1">
        <thead>
            <tr>
                <?php
                $channel = '<th width="100px">Channel</th>';
                $id = '<th width="100px">Campaign ID</th>';
                $campaign_name = '<th> Campaign Name</th>';
                $clicks = '<th> Clicks</th>';
                $cvr = '<th> Cvr</th>';
                $install = '<th> Install</th>';
                $payout = '<th> Payout</th>';
                $cost = '<th>Cost</th>';
                $pending_cost = '<th> Pending Cost</th>';
                $deduction_cost = '<th> Deduction Cost</th>';
                $payable = '<th> Payable</th>';
                ?>
            </tr>
        </thead>
        <tbody>
        <?php
            echo $channel;
            echo $id;
            echo $campaign_name;
            echo $clicks;
            echo $cvr;
            echo $install;
            echo $payout;
            echo $cost;
            echo $pending_cost;
            echo $deduction_cost;
            echo $payable;

        foreach ($campaignBills as $item) {
            if (!empty($item->campaign_id)){
                $channels = '<td>' . Html::encode($item->channel->username) . '</td>';
                $ids = '<td>' . Html::encode($item->campaign_id) . '</td>';
                $campaign_names = '<td width="130px">' . Html::encode($item->campaign->campaign_name) . '</td>';
                $clicks = '<td>' . Html::encode($item->clicks) . '</td>';
                if ($item->clicks >0){
                    $cvrs = '<td>' . Html::encode(round(($item->installs / $item->clicks) * 100, 2) . '%') . '</td>';
                } else {
                    $cvrs = '<td>0</td>';
                }
                $installs = '<td>' . Html::encode($item->installs) . '</td>';
                $payouts = '<td>' . $item->pay_out . '</td>';
                $costs = '<td>' . $item->cost . '</td>';
                $pending_costs = '<td>' . $item->pending_cost . '</td>';
                $deduction_costs = '<td>' . $item->deduction_cost . '</td>';
                $payables = '<td>' . Html::encode($item->cost-$item->pending_cost-$item->deduction_cost) . '</td>';
                $row = '<tr>' .$channels.$ids.$campaign_names.$clicks.$cvrs.$installs.$payouts.$costs.$pending_costs.$deduction_costs.$payables.'</tr>';
                echo $row;
            }
        }
        ?>
        </tbody>
    </table>
    <p>Thanks for your business.</p>
    <p>Have a nice day. </p>
    <p>Best regards</p>
    <p>SuperADS Support Team</p>
</div>