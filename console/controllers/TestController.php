<?php
/**
 * Created by PhpStorm.
 * User: Iven.Wu
 * Date: 2017-02-10
 * Time: 10:59
 */

namespace console\controllers;


use backend\models\FinanceAdvertiserCampaignBillTerm;
use common\models\AdvertiserApi;
use common\models\Campaign;
use common\models\CampaignLogHourly;
use common\models\CampaignStsUpdate;
use common\models\Config;
use common\models\Customer;
use common\models\Deliver;
use common\models\Feed;
use common\models\LogClick;
use common\models\LogClick2;
use common\models\LogClick3;
use common\models\LogClickDM;
use common\models\LogFeed;
use common\models\LogPost;
use common\models\ReportMatchInstallHourly;
use common\models\Stream;
use ConnectionTest;
use console\models\Affle;
use console\models\Glispa;
use console\models\Mi;
use console\models\Movista;
use console\models\Mundo;
use console\models\StaticsUtil;
use console\models\StatsUtil;
use console\models\Taptica;
use console\models\Yeahmobi;
use DateTime;
use DateTimeZone;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use HttpException;
use HttpRequest;
use linslin\yii2\curl\Curl;
use UrbanIndo\Yii2\DynamoDb\Connection;
use UrbanIndo\Yii2\DynamoDb\Query;
use Yii;
use yii\console\Controller;

/**
 * Class TestController
 * @package console\controllers
 */
class TestController extends Controller
{

    public function actionTmd()
    {
        $sub_redirect_key = 'sub-redirect' . 999;
        $sub_redirect = Yii::$app->cache->get($sub_redirect_key);
        var_dump($sub_redirect);
        if ($sub_redirect === false) {
            echo 777;
            Yii::$app->cache->set($sub_redirect_key, empty($sub_redirect) ? 0 : $sub_redirect, 3);
        }
        if(empty($sub_redirect)){
            echo "888\n";
        }

die();
//        Yii::$app->cache->set('test', Campaign::findById(88801));
//        var_dump(Yii::$app->cache->get('test'));
        for($i = 0;$i<100;$i++) {
            echo "999 \n";
//            $curl = new Curl();
            $stream = Array();
            $stream['click_uuid'] = uniqid();
            $stream['campaign_id'] = 888;
//            $stream = new LogClick();
//            $stream->click_uuid=uniqid();
//            $stream->campaign_id=888;
            var_dump($i);
            $curl = new Curl();
            $curl->setRequestBody(json_decode(json_encode($stream)));
            $curl->setHeaders( array(
                "cache-control: no-cache",
                "content-type: application/json",
            ));
//            $curl->post('http://kafka.superads.cn:6800/kafka/proxy/click/log',true);
            $curl = curl_init();

            curl_setopt_array($curl, array(
                CURLOPT_PORT => "6800",
                CURLOPT_URL => "http://kafka.superads.cn:6800/kafka/proxy/click/log",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode($stream),
                CURLOPT_HTTPHEADER => array(
                    "cache-control: no-cache",
                    "content-type: application/json",
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

        };
        die();
        $now = time();
        date_default_timezone_set('Etc/GMT-8');
        $hourly = date('Y-m-d H:00', 1497855300);
        $aa = strtotime('20170601');
        $hourly_aa = date('Y-m-d H:i', $aa);
        echo $hourly . "\n";
        echo $aa . "\n";
        echo $hourly_aa . "\n";

        die();

        $feed = LogFeed::findOne(['id' => 24524]);
        ReportMatchInstallHourly::updateInstalls($feed);
        die();
        /* $i = 0;
         while ($i < 1000) {

             $aa = new LogClickDM();
             $aa->click_id = 8989;
             $aa->click_uuid = uniqid();
             $aa->click_time = time();

             $aa->click_id = uniqid();
             $aa->campaign_channel_id = '88900_7788';
             $aa->ch_subid = uniqid();
             $aa->adv_price = time();
             $aa->pay_out = time();
             $aa->all_parameters = uniqid();
             $aa->ip_long = time();
             $aa->save();
             var_dump($aa->errors);
             $i++;
             echo  $i."\n";
         }
         die();*/
//        $aa->setFindType(Query::USING_GET_ITEM);
//       $bb = $aa->findById('59664cfd10d2e59664cfd10dd6641321');
//        $db = Yii::$app->dynamodb;

//        $command = Yii::$app->dynamodb->createCommand();
//        /* @var $command \UrbanIndo\Yii2\DynamoDb\Command */
//        $table = Customer::tableName();
//        if ($command->tableExists($table)) {
//            $command->deleteTable($table)->execute();
//        }
//        $command->createTable($table, [
//            'AttributeDefinitions' => [
//                [
//                    'AttributeName' => 'id',
//                    'AttributeType' => 'N'
//                ]
//            ],
//            'KeySchema' => [
//                [
//                    'AttributeName' => 'id',
//                    'KeyType' => 'HASH',
//                ]
//            ],
//            'ProvisionedThroughput' => [
//                'ReadCapacityUnits' => 10,
//                'WriteCapacityUnits' => 10
//            ],
//        ])->execute();
//        die();
//        $i=0;
//while ($i<100) {
        var_dump(LogClickDM::isExistIp('183872_188', 1732963635));

//        var_dump($aa);
        die();
//    $objectToInsert->save(false);
//    $i++;
//}
        $objectFromFind = Customer::findAll(['id' => 42976]);

//        var_dump($objectFromFind);
//        die();
        $db = Yii::$app->dynamodb;
//        $tableDescription =  $db->createCommand()->getItem('log_click_dm',['click_uuid'=>"59676f65e8e0d"])->execute();

//        var_dump($tableDescription);

        var_dump(LogClickDM::findOne(['click_uuid' => '59676f65e8e0d']));
        die();


        /*        $redis = Yii::$app->redis;
        //        $result = $redis->executeCommand('hmset', ['test_collection', 'key1', 'val1', 'key2', 'val2']);
                $result = $redis->executeCommand('hmset', ['aa', 'bb', 'val1', 'key2', 'val2']);
        //        var_dump($result);
                $var2 = Yii::$app->redis->keys("*");
                $source = Yii::$app->redis->hgetall('aa');
                var_dump($var2);
                var_dump($source);*/
        die();

        $now = time();
        $hourly = date('Y-m-d H:00', 1497855300);
        $aa = strtotime('20170601');
        $hourly_aa = date('Y-m-d H:i', $aa);
        echo $hourly . "\n";
        echo $aa . "\n";
        echo $hourly_aa . "\n";

        die();
//        $query = new Query();
//        $query->select('*');
//        $query->from('log_click');
//        $query->where(['click_uuid'=>'59434bff139e459434bff13a86399162']);
//        $query->limit(10);
//        $query->orderBy('create_time desc');
//
//
//
//        $command = $query->createCommand(\Yii::$app->db2);
//        var_dump($command->queryAll());

        $rows = \Yii::$app->db->createCommand("select * from log_click where click_uuid='5942a8bf346665942a8bf34708328179'");
        var_dump($rows->queryAll());
        die();
        echo date('Y-m-d\TH:i:s\Z', (time() - $now)) . "\n";
        die();
        $aa = new Mundo();
        $aa->getApiCampaign();

        date_default_timezone_set('Etc/GMT-8');
        echo strtotime('2017/05/17');
        echo date('Y-m-d H:i:s', 1495036800);
//      $aa = new StatsUtil();
//      $aa->statsClicksHourly(time(),time());
//        }
        die();


//        $start = date('Y-m-d H:00', time());
//        echo $start . "\n";
//        date_default_timezone_set("Etc/GMT-0");
//        $start = date('Y-m-d H:00', time());
//        echo $start . "\n";
        $first_day_str = date('Y-m-d H:00', strtotime('first day of this month'));
        echo $first_day_str . "\n";
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

    public static function actionCtt(){
//        $file_name="/var/www/html/spa/console/controllers/log.txt";
//        $fp=fopen($file_name,'r');
//        while(!feof($fp))
//        {
//            $buffer=fgets($fp,4096);
//            echo $buffer."<br>";
//        }
//        fclose($fp);
        $a=10;

        $result=$a +  ++$a +  ++$a;
        echo $result;
    }
}