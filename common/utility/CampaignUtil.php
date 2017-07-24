<?php
namespace common\utility;

use yii\helpers\Html;
use common\models\Campaign;
/**
 * Created by PhpStorm.
 * User: ASUS
 * Date: 2017/7/20
 * Time: 15:30
 */
class CampaignUtil{

    /**生成campaign_info模板
     * @param $deliver
     * @return string
     */
    public static function genCampaignInfo($deliver){
        $tmpl = '<style type="text/css">
        table {
            border-spacing: 0;
            border-collapse: collapse;
            background-color: #ffffff;
            border-color: #ccc;
            font-family: "microsoft yahei", calibri, verdana;
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
        <table border="1">
            <thead>
                <tr>
                    <th width="100px">Campaign ID</th>
                    <th> Campaign name</th>
                    <th> Target GEO</th>
                    <th> Platform</th>
                    <th> Payout</th>
                    <th> Cap</th>
                    <th>Traffic Source</th>
                    <th> Preview Link</th>
                    <th> KPI</th>
                </tr>
                </thead>
                <tbody>
                    <tr>'.
                        $ids = '<td>' . Html::encode($deliver->campaign->id) . '</td>'.
                        $campaign_names = '<td width="130px">' . Html::encode($deliver->campaign->campaign_name) . '</td>'.
                        $target_geos = '<td>' . Html::encode($deliver->campaign->target_geo) . '</td>'.
                        $platforms = '<td>' . Html::encode($deliver->campaign->platform) . '</td>'.
                        $payouts = '<td>' . Html::encode($deliver->pay_out) . '</td>'.
                        $cap = '<td>' . Html::encode($deliver->daily_cap) . '</td>'.
                        $traffic_sources = '<td>' . $deliver->campaign->traffic_source . '</td>'.
                        $preview_links = '<td><a href="' . Html::encode($deliver->campaign->preview_link) . '">Preview Link</a></td>'.
                        $kpi = '<td>' . Html::encode($deliver->campaign->kpi) . '</td>'.'
                         </tr>
                         </tbody>
                    </table>
                </div>';
        return str_replace("  ","",$tmpl);
    }
}