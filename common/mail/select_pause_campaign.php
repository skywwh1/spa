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
                $effect_time = '<th> Effect Time</th>';
                $why_stop = '<th> Why Stop</th>';
                $impacted = '<th> Impacted Channel</th>';
                ?>
            </tr>
        </thead>
        <tbody>
        <?php
          echo $id;
          echo $campaign_name;
          echo $campaign_uuid;
          echo $effect_time;
          echo $why_stop;
          echo $impacted;

        foreach ($campaigns as $campaign) {
            $ids = '<td>' . Html::encode($campaign->id) . '</td>';
            $campaign_names = '<td width="130px">' . Html::encode($campaign->campaign_name) . '</td>';
            $campaign_uuids = '<td>' . Html::encode($campaign->campaign_uuid) . '</td>';
            $effect_time = '<td>' . Html::encode($campaign->effective_time) . '</td>';
            $why_stop = '<td></td>';
            $impacted = '<td>' . $campaign->impacted_channels . '</td>';
            $row = '<tr>' .$ids.$campaign_names.$campaign_uuids.$effect_time.$why_stop.$impacted.'</tr>';

            echo $row;
        }

        ?>
        </tbody>
    </table>
</div>