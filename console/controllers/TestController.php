<?php
/**
 * Created by PhpStorm.
 * User: Iven.Wu
 * Date: 2017-02-10
 * Time: 10:59
 */

namespace console\controllers;


use common\models\Campaign;
use common\models\CampaignLogHourly;
use common\models\CampaignStsUpdate;
use common\models\Config;
use common\models\Deliver;
use common\models\Feed;
use common\models\LogClick;
use common\models\LogFeed;
use common\models\LogPost;
use common\models\Stream;
use console\models\Glispa;
use console\models\Movista;
use console\models\StaticsUtil;
use console\models\StatsUtil;
use console\models\Yeahmobi;
use DateTime;
use DateTimeZone;
use linslin\yii2\curl\Curl;
use yii\console\Controller;

/**
 * Class TestController
 * @package console\controllers
 */
class TestController extends Controller
{

    public function actionTmd()
    {
        echo 'Next Week: '. date('Y-m-d', strtotime('-3 month')) ."\n";
        echo 'Next Week: '. strtotime('-3 month')."\n";
        die();
        $stats = new StatsUtil();
        $start = Config::findLastStatsHourly();
        $end = time();
        $start_time = strtotime(date("Y-m-d H:00", $start - 3600));//统计两个小时，防止出错
        $end_time = strtotime(date("Y-m-d H:00", $end + 3600));
        echo 'start time hourly' . $start_time . "\n";
        echo 'end time hourly' . $end_time . "\n";
        $stats->statsRedirectInstallHourly($start_time, $end_time);
        die();
        $aa = new Movista();
        $aa->getApiCampaign();

        die();
//        $aa = new Glispa();
//        $aa->getApiCampaign();
//        echo $bb;

//        $a = 'dsf';
//        $records = array();
//        for($i = 1;$i<10;$i++){
//
//            $records[$i.$a]=$i;
//        }
//        var_dump($records);
//        $stats = new StatsUtil();
//        $stats->statsMatchInstallHourly();
//        die();
        //echo ip2long('177.66.48.90');

        //  $hourly = CampaignLogHourly::findIdentity(89053, 44, 1488585600);
//        $stats->updatePrice();
//        $stats->statsDaily();
//var_dump(empty(null));
//var_dump(strtotime(date("Y-m-d", time())));
//        var_dump(time());
//        $stats->statsHourly(1);
//        $stats->statsClickDaily();
//$stats->statsMatchInstallDaily();
//        date_default_timezone_set("Asia/Shanghai");
//        print (date("Y-m-d H", time()));
//        var_dump( strtotime(date("Y-m-d H:00", time())));
//        var_dump(Config::updateStatsTimeHourly(1, time()));
        date_default_timezone_set("Asia/Shanghai");
        $start = strtotime(date('Y-m-d H:00', time() - 3600 * 24));
        echo $start . "\n";
        echo date('Y-m-d H:00', $start) . "\n";
//        echo $start . "\n";
        die();
        $start = new DateTime('2017-03-06 11:00', new DateTimeZone('Asia/Shanghai'));
        var_dump($start->format('Y-m-d H:i:sP'));
//        $stats->
        $date = new DateTime('2017-03-06 11:00', new DateTimeZone('Etc/GMT-11'));
        echo $date->format('Y-m-d H:i:sP') . "\n";
        echo $date->getTimestamp() . "\n";

        $date->setTimezone(new DateTimeZone('Etc/GMT+7'));
        echo $date->format('Y-m-d H:i:sP') . "\n";
    }
}