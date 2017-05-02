<?php
/**
 * Created by PhpStorm.
 * User: Iven.Wu
 * Date: 2017-02-10
 * Time: 10:59
 */

namespace console\controllers;


use backend\models\FinanceAdvertiserCampaignBillTerm;
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
use HttpException;
use HttpRequest;
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

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => "http://api.nposting.com/campaign/lists?lang=english&api_cd=f421b8d6334cf1971ebfa56b49fdedc2",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "postman-token: b672eb4b-c318-7628-9f86-b07e1acb9175",
                "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/58.0.3029.81 Safari/537.36",
                "Cookie: "
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "cURL Error #:" . $err;
        } else {
            echo $response;
        }

//        echo strtotime('2017-04-01')."\n";
//        echo  date('Y-m-d', strtotime('2017-04-01'));
//        die();
//        $aa = FinanceAdvertiserCampaignBillTerm::statsByAdv(1488294000,1490972400,17);
//        var_dump($aa);
//        die();
//        $month = strtotime('2017-01-01');
//        $end = time();
//        while($month < $end)
//        {
//            $aa  = date('F', $month);
//            echo $aa, PHP_EOL;
//            $month = strtotime("+1 month", $month);
//            echo strtotime('last day of '.$aa), PHP_EOL;
//            echo date('Y m d',strtotime('last day of '.$aa)), PHP_EOL;
//        }
        die();

        $end = time();


//        $start = date('Y-m-d H:00', time());
//        echo $start . "\n";
//        date_default_timezone_set("Etc/GMT-0");
//        $start = date('Y-m-d H:00', time());
//        echo $start . "\n";
        $first_day_str = date('Y-m-d H:00', strtotime('first day of this month'));
        echo $first_day_str."\n";
        die();
        $last_day_str = date('Y-m-d H:00', strtotime('last day of last month'));
//        echo date('Y-m-d', strtotime('last day of last month'));
                $timezone = 'Etc/GMT-8';
//        echo date('Y-m-d H:00', time())."\n";

        strtotime($first_day_str);
        $date = new DateTime('2017-03-01', new DateTimeZone('Etc/GMT-8'));
        echo date('Y-m-d H:00', $date->getTimestamp());

//        $date = new DateTime(date('Y-m-d H:00', time()), new DateTimeZone('UTC'));
//            echo $date->getTimestamp() . "\n";
//        echo date('Y-m-d H:00', $date->getTimestamp())."\n";
        die();
        echo time() . "\n";
        echo date('Y-m-d H:00', time()) . "\n";
        $date = new DateTime(date('Y-m-d H:00', time()), new DateTimeZone('Etc/GMT+8'));
        echo $date->format('Y-m-d H:i:sP') . "\n";
        echo $date->getTimestamp() . "\n";
        echo date('Y-m-d H:00', $date->getTimestamp());
//        $start = new DateTime('2017-03-06 11:00', new DateTimeZone('Asia/Shanghai'));
//        var_dump($start->format('Y-m-d H:i:sP'));
//        $stats = new StatsUtil();
//        $stats->statsFeedHourly(0,time());
//        echo date('Y-m-d', strtotime('last day of last month'));
//        echo 'Next Week: ' . date('Y-m-d', strtotime('-3 month')) . "\n";
//        echo 'Next Week: ' . strtotime('-3 month') . "\n";
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