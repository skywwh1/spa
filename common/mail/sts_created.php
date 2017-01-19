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
        font-size: 16px;
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

    <p>&nbsp;&nbsp; &nbsp;Here are some new campaigns for you today. If you need any help, please feel free to contact
        me.</p>

    <p>&nbsp;&nbsp; &nbsp;Note:&nbsp;admin@superads.cn&nbsp;is a <strong>NO-REPLY</strong> email. Please reply to your
        beloved account managers ONLY.</p>

    <table>
        <thead>
        <tr>
            <th colspan="13">
                NEW Campaigns
            </th>
        </tr>
        <tr>
            <th>
                ID
            </th>
            <th>
                Campaign name
            </th>
            <th>
                Version
            </th>
            <th>
                Target Geo
            </th>
            <th>
                Payout
            </th>
            <th>
                Link
            </th>
            <th>
                Creative
            </th>
            <th>
                Traffic Source
            </th>
            <th>
                Daily Cap
            </th>
            <th>
                Notes
            </th>
            <th>
                Exclude Traffic
            </th>
            <th>
                Conversion Flow
            </th>
            <th>
                Carrier
            </th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td><?= Html::encode($deliver->campaign->id) ?></td>
            <td><?= Html::encode($deliver->campaign->campaign_name) ?></td>
            <td><?= Html::encode($deliver->campaign->version) ?></td>
            <td><?= Html::encode($deliver->campaign->targetGeo->domain) ?></td>
            <td><?= Html::encode($deliver->pay_out) ?></td>
            <td><?php
                $url = Url::home(true);
                $url = str_replace('admin', 'track', $url);
                $url = chop($url, "/");
                $url .= $deliver->track_url;
                echo Html::a('Tracking Link ', $url) ?>
            </td>
            <td><?= Html::encode($deliver->campaign->creative_link) ?></td>
            <td><?= Html::encode($deliver->campaign->traffice_source) ?></td>
            <td><?= Html::encode($deliver->daily_cap) ?></td>
            <td><?= Html::encode($deliver->note) ?></td>
            <td></td>
            <td><?= Html::encode($deliver->campaign->conversion_flow) ?></td>
            <td><?= Html::encode($deliver->campaign->carriers) ?></td>

        </tr>
        </tbody>
    </table>
    <p>Have a nice day. </p>
    <p>Best regards</p>
    <p>SuperAds Admin</p>
</div>
