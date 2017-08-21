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

    <h4>Hi all,</h4>

    <table border="1">
        <thead>
            <tr>
                <?php
                $id = '<th width="100px">Campaign ID</th>';
                $campaign_name = '<th> Campaign name</th>';
                $campaign_uuid = '<th> Campaign Uuid</th>';
                $target_geo = '<th> Target GEO</th>';
                $platform = '<th> Platform</th>';
                $payout = '<th> Payout</th>';
                $traffic_source = '<th>Traffic Source</th>';
                $preview_link = '<th> Preview Link</th>';
                $creative_link = '<th> Creative Link</th>';
                $kpi = '<th> KPI</th>';
                ?>
            </tr>
        </thead>
        <tbody>
        <?php
          echo $id;
          echo $campaign_name;
          echo $campaign_uuid;
          echo $target_geo;
          echo $platform;
          echo $payout;
          echo $traffic_source;
          echo $preview_link;
          echo $creative_link;
          echo $kpi;

        foreach ($campaigns as $campaign) {
            $ids = '<td>' . Html::encode($campaign->id) . '</td>';
            $campaign_names = '<td width="130px">' . Html::encode($campaign->campaign_name) . '</td>';
            $campaign_uuids = '<td>' . Html::encode($campaign->campaign_uuid) . '</td>';
            $target_geos = '<td>' . Html::encode($campaign->target_geo) . '</td>';
            $platforms = '<td>' . Html::encode($campaign->platform) . '</td>';
            $payouts = '<td>' . Html::encode($campaign->now_payout) . '</td>';
            $traffic_sources = '<td>' . $campaign->traffic_source . '</td>';
            $preview_links = '<td><a href="' . Html::encode($campaign->preview_link) . '">Preview Link</a></td>';
            $creativeSet = null;
            foreach ($campaign->campaignCreateLinks as $item){
                $creativeSet .= !empty($item) ? '<a href="' . Url::to($item->creative_link) . '">Banner</a><br />' : '';
            }

            $creative = '<td>' . $creativeSet . '</td>';
            $kpis = '<td>' . Html::encode($campaign->kpi) . '</td>';
            $row = '<tr>' .$ids.$campaign_names.$campaign_uuids.$target_geos.$platforms.$payouts.$traffic_sources.$preview_links.$creative.$kpis.'</tr>';

            echo $row;
        }
        ?>
        </tbody>
    </table>

    <table border="1">
        <thead>
        <tr>
            <?php
            $tag = '<th> Tag</th>';
            $direct = '<th> Direct</th>';
            $adv = '<th> Advertiser</th>';
            $daily_cap = '<th> DailyCap</th>';
            $note = '<th> Note</th>';
            ?>
        </tr>
        </thead>
        <tbody>
        <?php
        echo PHP_EOL;
        echo $tag;
        echo $direct;
        echo $adv;
        echo $daily_cap;
        echo $note;
        foreach ($campaigns as $campaign) {
            $tags = '<td>' . Html::encode(ModelsUtil::getCampaignTag($campaign->tag)) . '</td>';
            $directs = '<td>' . Html::encode(ModelsUtil::getCampaignDirect($campaign->direct)) . '</td>';
            $advs = '<td>' . Html::encode($campaign->advertiser0->username) . '</td>';
            $daily_caps = '<td>' . Html::encode($campaign->daily_cap) . '</td>';
            $notes = '<td>' . Html::encode($campaign->note) . '</td>';
            $row = '<tr>' .$tags.$directs.$advs.$daily_caps.$notes.'</tr>';

            echo $row;
        }

        ?>
        </tbody>
    </table>
</div>