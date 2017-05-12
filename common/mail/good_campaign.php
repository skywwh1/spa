<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $campaigns common\models\Campaign[] */
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
        if (!empty($channel->contacts)) {
            echo Html::encode($channel->contacts);
        } else {
            echo Html::encode($channel->username);
        } ?>:</h4>

    <p>&nbsp;&nbsp; &nbsp;Good day! </p>

    <p>&nbsp;&nbsp; &nbsp;Here’re some good offers recommendations. If you have any interested offers, you can click “Apply” or let me know..</p>

    <table border="1">
        <thead>
            <tr>
                <?php
                $action = '<th width="100px">Action</th>';
                $id = '<th width="100px">Campaign ID</th>';
                $campaign_name = '<th> Campaign name</th>';
                $target_geo = '<th> Target GEO</th>';
                $platform = '<th> Platform</th>';
                $payout = '<th> Payout</th>';
                $traffic_source = '<th>Traffic Source</th>';
                $preview_link = '<th> Preview Link</th>';
                ?>
            </tr>
        </thead>
        <tbody>
        <?php
          echo $action;
          echo $id;
          echo $campaign_name;
          echo $target_geo;
          echo $platform;
          echo $payout;
          echo $traffic_source;
          echo $preview_link;

        foreach ($campaigns as $campaign) {
            $actions = '<td><a href="http://superads.cn/camp-log/alloffers">Apply</a>';
            $ids = '<td>' . Html::encode($campaign->id) . '</td>';
            $campaign_names = '<td width="130px">' . Html::encode($campaign->campaign_name) . '</td>';
            $target_geos = '<td>' . Html::encode($campaign->target_geo) . '</td>';
            $platforms = '<td>' . Html::encode($campaign->platform) . '</td>';
            $payouts = '<td>' . Html::encode($campaign->now_payout) . '</td>';
            $traffic_sources = '<td>' . $campaign->traffic_source . '</td>';
            $preview_links = '<td><a href="' . Html::encode($campaign->preview_link) . '">Preview Link</a></td>';
//            $link .= '<td><a href="' . Url::to('@track' . $campaign->track_url) . '">Tracking Link</a></td>';
            $row = '<tr>' .$actions.$ids.$campaign_names.$target_geos.$platforms.$payouts.$traffic_sources.$preview_links.'</tr>';

            echo $row;
        }

        ?>
        </tbody>
    </table>
    <p>Thanks for your business.</p>
    <p>Have a nice day. </p>
    <p>Best regards</p>
    <p>SuperADS Support Team</p>
</div>