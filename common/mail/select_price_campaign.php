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
                $original_advPrice = '<th> Original AdvPrice</th>';
                $updated_advPrice = '<th> Updated AdvPrice</th>';
                $effect_time = '<th> Effect Time</th>';
                $impacted = '<th> Impacted Channel</th>';
                ?>
            </tr>
        </thead>
        <tbody>
        <?php
          echo $id;
          echo $campaign_name;
          echo $campaign_uuid;
          echo $original_advPrice;
          echo $updated_advPrice;
          echo $effect_time;
          echo $impacted;

        foreach ($campaigns as $campaign) {
            $ids = '<td>' . Html::encode($campaign->id) . '</td>';
            $campaign_names = '<td width="130px">' . Html::encode($campaign->campaign_name) . '</td>';
            $campaign_uuids = '<td>' . Html::encode($campaign->campaign_uuid) . '</td>';
            $original_advPrices = '<td>' . Html::encode($campaign->adv_price) . '</td>';
            $updated_advPrices = '<td>' . Html::encode($campaign->newValue) . '</td>';
            $effect_time = '<td>' . Html::encode($campaign->effective_time) . '</td>';
            $impacted = '<td>' . $campaign->impacted_channels . '</td>';
            $row = '<tr>' .$ids.$campaign_names.$campaign_uuids.$original_advPrices.$updated_advPrices.$effect_time.$impacted.'</tr>';

            echo $row;
        }

        ?>
        </tbody>
    </table>
</div>