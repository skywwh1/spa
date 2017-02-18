<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $delivers common\models\Deliver[] */
/* @var $channel common\models\Channel */

?>
<style type="text/css">
    .divTable {
        display: table;
        width: 80%;
    }

    .divTableRow {
        display: table-row;
    }

    .divTableCell, .divTableHead {
        border: 1px solid #999999;
        display: table-cell;
        padding: 3px 10px;
    }

    .divTableHeading {
        background-color: #EEE;
        font-weight: bold;
        display: table-cell;
        border: 1px solid #999999;
        padding: 3px 10px;
    }

    .divTableFoot {
        background-color: #EEE;
        display: table-footer-group;
        font-weight: bold;
    }

    .divTableBody {
        display: table-row-group;
    }
</style>
<div class="sts_created" xmlns="http://www.w3.org/1999/html" xmlns="http://www.w3.org/1999/html">

    <h4>Dear <?= Html::encode($channel->username) ?>:</h4>

    <p>&nbsp;&nbsp; &nbsp;Hope this email finds you well.</p>

    <p>&nbsp;&nbsp; &nbsp;Here are some new campaigns for you today. If you need any help, please feel free to contact
        me.</p>

    <p>&nbsp;&nbsp; &nbsp;Note:&nbsp;admin@superads.cn&nbsp;is a <strong>NO-REPLY</strong> email. Please reply to your
        beloved account managers ONLY.</p>
    <div class="divTable" style="border: 1px solid #000;">
        <div class="divTableBody">
            <?php
            $id = '<div class="divTableHeading"> ID</div>';
            $campaign_name = '<div class="divTableHeading"> Campaign name</div>';
            $version = '<div class="divTableHeading"> Version</div>';
            $target_geo = '<div class="divTableHeading"> Target Geo</div>';
            $payout = '<div class="divTableHeading"> Payout</div>';
            $preview_link = '<div class="divTableHeading">Preview Link</div>';
            $link = '<div class="divTableHeading"> Link</div>';
            $creative = '<div class="divTableHeading"> Creative</div>';
            $traffic_source = '<div class="divTableHeading"> Traffic Source</div>';
            $daily_cap = '<div class="divTableHeading"> Daily Cap</div>';
            $notes = '<div class="divTableHeading"> Notes</div>';
            //            $exclude_traffic = '<div class="divTableHeading"> Exclude Traffic</div>';
            $conversion_flow = '<div class="divTableHeading"> Conversion Flow</div>';
            $carrier = '<div class="divTableHeading"> Carrier</div>';

            foreach ($delivers as $deliver) {
                $id .= '<div class="divTableCell">' . Html::encode($deliver->campaign->id) . '</div>';
                $campaign_name .= '<div class="divTableCell">' . Html::encode($deliver->campaign->campaign_name) . '</div>';
                $version .= '<div class="divTableCell">' . Html::encode($deliver->campaign->version) . '</div>';
                $target_geo .= '<div class="divTableCell">' . Html::encode($deliver->campaign->targetGeo->domain) . '</div>';
                $payout .= '<div class="divTableCell">' . Html::encode($deliver->pay_out) . '</div>';
                $preview_link .= '<div class="divTableCell"><a href="' . $deliver->campaign->preview_link . '">Preview Link Link</a></div>';
                $link .= '<div class="divTableCell"><a href="' . Url::to('@track' . $deliver->track_url) . '">Tracking Link</a></div>';
                $creative .= '<div class="divTableCell">' . Html::encode($deliver->campaign->creative_link) . '</div>';
                $traffic_source .= '<div class="divTableCell">' . Html::encode(ModelsUtil::getTrafficeSource($deliver->campaign->traffic_source)) . '</div>';
                $daily_cap .= '<div class="divTableCell">' . Html::encode($deliver->daily_cap) . '</div>';
                $notes .= '<div class="divTableCell">' . Html::encode($deliver->note) . '</div>';
                $conversion_flow .= '<div class="divTableCell">' . Html::encode($deliver->campaign->conversion_flow) . '</div>';
                $carrier .= '<div class="divTableCell">' . Html::encode($deliver->campaign->carriers) . '</div>';
            }

            $id = '<div class="divTableRow">' . $id . '</div>';
            $campaign_name = '<div class="divTableRow">' . $campaign_name . '</div>';
            $version = '<div class="divTableRow">' . $version . '</div>';
            $target_geo = '<div class="divTableRow">' . $target_geo . '</div>';
            $payout = '<div class="divTableRow">' . $payout . '</div>';
            $preview_link = '<div class="divTableRow">' . $preview_link . '</div>';
            $link = '<div class="divTableRow">' . $link . '</div>';
            $creative = '<div class="divTableRow">' . $creative . '</div>';
            $traffic_source = '<div class="divTableRow">' . $traffic_source . '</div>';
            $daily_cap = '<div class="divTableRow">' . $daily_cap . '</div>';
            $notes = '<div class="divTableRow">' . $notes . '</div>';
            //            $exclude_traffic = '<div class="divTableRow">' . $exclude_traffic . '</div>';
            $conversion_flow = '<div class="divTableRow">' . $conversion_flow . '</div>';
            $carrier = '<div class="divTableRow">' . $carrier . '</div>';

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
        </div>
    </div>
    <p>Have a nice day. </p>
    <p>Best regards</p>
    <p>SuperAds Admin</p>
</div>
