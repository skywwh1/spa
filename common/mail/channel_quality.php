<?php
use yii\helpers\Html;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $cols array */
/* @var $columnName array */
/* @var $subChannels array */
/* @var $campaign common\models\Campaign */
/* @var $date_range string*/

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
//        echo Html::encode($channel->username);
        echo Html::encode(yii::$app->user->identity->username);
        ?>:</h4>

    <p>&nbsp;&nbsp; &nbsp;Good day! </p>

    <?php
       echo '<p>&nbsp;&nbsp; &nbsp;Here’re quality report on the campaign '.Html::encode($campaign->id).'('.Html::encode($campaign->campaign_name).') in period '.Html::encode($date_range).'.</p>';
       if (!empty($campaign->kpi)){
           echo '<p>&nbsp;&nbsp; &nbsp;KPI :'.Html::encode($campaign->kpi).'.</p>';
       }
    ?>

    <table border="1">
        <thead>
            <tr>
                <?php
                    $channel_name = '<th> Channel Name</th>';
                    $sub_channel = '<th> SubChannel</th>';
                    $click = '<th> Clicks</th>';
                    $unique_click = '<th>Unique Clicks</th>';
                    $install = '<th> Installs</th>';
                    $cvr = '<th> CVR</th>';

                ?>
            </tr>
        </thead>
        <tbody>
        <?php
          echo $channel_name;
          echo $sub_channel;
          echo $click;
          echo $unique_click;
          echo $install;
          echo $cvr;
          foreach($cols as $key=>$value){
              echo '<th>'.$key.'</th>';
          }

        $index = 0;
        foreach ($subChannels as $item) {
            $channel_names = '<td>' . Html::encode($item['channel_name']) . '</td>';
            $sub_channels = '<td>' . Html::encode($item['sub_channel']) . '</td>';
            $clicks = '<td>' . Html::encode($item['clicks']) . '</td>';
            $unique_clicks = '<td>' . $item['unique_clicks'] . '</td>';
            $installs = '<td>' . Html::encode($item['installs']) . '</td>';
            if ($item['clicks'] > 0) {
                $cvrs = '<td>' . Html::encode(round(($item['installs'] / $item['clicks']) * 100, 2) . '%') . '</td>';
            }else{
                $cvrs = '<td>' .'0%' . '</td>';
            }
//            $row = '<tr>' .$ids.$campaign_names.$channel_names.$sub_channels.$clicks.$unique_clicks.$installs.$cvrs.'</tr>';
            $row = '<tr>' .$channel_names.$sub_channels.$clicks.$unique_clicks.$installs.$cvrs;

            foreach ($cols as $key=>$value){
                if (!empty($columnName[$index])){
                    $dynamic_value = '<td>' . Html::encode($columnName[$index][$key]) . '</td>';
                }else{
                    $dynamic_value = '<td>' . Html::encode('not-set') . '</td>';
                }
                $row = $row.$dynamic_value;
            }
            $index++;
            $row.'</tr>';

            echo $row;
        }

        ?>
        </tbody>
    </table>
    <p>&nbsp;&nbsp; &nbsp;Pls optimize accordingly asap!</p>
    <p>Thanks for your business.</p>
    <p>Have a nice day. </p>
    <p>Best regards</p>
    <p>SuperADS Support Team</p>
</div>