<?php
namespace console\controllers;

use common\models\AdvertiserApi;
use common\models\Campaign;
use common\models\Channel;
use common\models\Deliver;
use common\utility\ApiUtil;
use common\utility\MailUtil;
use linslin\yii2\curl\Curl;
use rmrevin\yii\geoip\HostInfo;
use yii\base\Model;
use yii\console\Controller;
use yii\db\BaseActiveRecord;

/**
 * Created by PhpStorm.
 * User: wh wu
 * Date: 1/15/2017
 * Time: 3:39 PM
 */
class StsController extends Controller
{

    public function actionSendCreate()
    {
        $delivers = Deliver::getAllNeedSendCreate();
        if (!empty($delivers)) {
            $data = array();
            foreach ($delivers as $deliver) {
                $data[$deliver->channel_id][] = $deliver;
            }
            foreach ($data as $k => $v) {
                $channel = Channel::findOne(['id' => $k]);
                $this->echoMessage("Time : " . date("Y-m-d H:i:s", time()));
                $this->echoMessage(MailUtil::sendStsChannelMail($channel, $v));
                $this->echoMessage("waiting 90s");
                sleep(90);

            }
        }
    }

    private function echoMessage($str)
    {
        echo " \t $str \n";
    }

    public function actionTest()
    {
        /**
         * $curl = new Curl();
         *
         * //get http://example.com/
         * // $response = $curl->get('https://api.github.com/');
         * //        var_dump(time());
         * $key = 'UDXBT02KMWXZYD8FBBWM';
         *
         * $url = 'http://3s.mobvista.com/v4.php?m=index&cb=cb7654';
         * //        &time=1486136870&token=626e571473f6f4d749c38d09b9845feb'
         * $time = time();
         * $token = md5($key.md5($time));
         * $url .= '&time='.$time;
         * $url .= '&token='.$token;
         * // $response = $curl->get($url);
         * // echo '<pre>';
         * $string = "beautiful";
         * //        $time = "winter";
         *
         * $str = 'This is a $string $time morning!';
         * echo $str. "\n";
         *
         * eval("\$str = \"$str\";");
         * echo $str;
         * //var_dump($url);
         * // var_dump($response);
         **/
        $apis = AdvertiserApi::findOne(['id' => 4]);
        $url = $apis->url;
        $apis->getAttribute('key');
        $param = $apis->param;
        $param = $this->replaceValue($param, $apis); // 替换key
//        echo $param;
        $paras = explode('&', $param);
        $aa = '';
        foreach ($paras as $item) {
            $item = $this->replaceUrl($item);
            $aa .= $item . '&';
        }
        $aa = rtrim($aa, '&');
        $url .= '?' . $aa;
        //echo $url;
        $curl = new Curl();
        $response = $curl->get($url);
        if (json_decode($response)) {
            $data = json_decode($response);
            $camps = array();
            foreach ($data as $k => $v) {
                if ($k == 'offers') {
//                    var_dump(count($v));
                    foreach ($v as $item) { //循环json里面的offers
                        $item = (array)$item;
                        $camp = new Campaign();
                        $camp_attrs = $camp->getAttributes();
                        $apis_attrs = $apis->getAttributes();
                        foreach ($apis_attrs as $api_k => $api_v) { //循环apis 的属性
                            if (array_key_exists($api_v, $item)) { //如果 json每一个offer的属性存在apis里面。
                                if (array_key_exists($api_k, $camp_attrs)) { // 并且campaign里面的属性也存在。
                                    if (is_array($item[$api_v])) {
                                        $camp->setAttribute($api_k, implode(',', $item[$api_v]));
                                    } else {
                                        $camp->setAttribute($api_k, $item[$api_v]);
                                    }
                                }
                            }
                        }
                        $camps[] = $camp;
                    }
                }
            }
            var_dump($camps);

        }
//        var_dump(json_decode($response));


    }

    public function replaceUrl($str)
    {
        //	m=index&cb=cb7654&time={time();}&token={md5($key.md5(time(););}
        if (strpos($str, '{') && strpos($str, '}')) {
            $param = strstr($str, '=', true);  //前
            $val = strstr($str, '='); // =后
            $val = substr($val, 0, -1); //去掉后面一个
            $val = substr($val, 2, strlen($val) - 2); //去电后面两个
            $val = $this->replaceFunc($val);
            return $param . '=' . $val;
        } else {
            return $str;
        }
    }

    public function replaceFunc($str)
    {
        $fun = 'return ' . $str;
        return eval($fun); // 15
    }

    /**
     * @param $str
     * @param BaseActiveRecord $model
     * @return mixed
     */
    public function replaceValue($str, $model)
    {
        if (strpos($str, '"')) {
            $vs = explode('"', $str);
            foreach ($vs as $item) {
                if ($model->getAttribute($item)) {
                    $str = str_replace($item, $model->getAttribute($item), $str);
                }
            }
        }
        return $str;
    }

    public function actionMat()
    {
//        $apis = AdvertiserApi::findOne(['id' => 4]);
////        var_dump();
//        $camps = ApiUtil::genCampaigns($apis);
//        foreach ($camps as $i){
//            var_dump($i->app_size);
////            if(!$i->save()){
////                var_dump($i->getErrors());
////            }
//        }
//        $curl = new Curl();
//       $re = $curl->post('http://api.mobra.in/v1/auth/login?user=boster@superads.cn&password=Mobrain123',false);

//           ->get('https://api.mobra.in/v1/campaign/feed');
//        var_dump($re);
//        var_dump($curl->responseHeaders);
//            var_dump($curl->get('https://api.mobra.in/v1/campaign/feed'));
//        $region = geoip_region_by_name('superads.cn');
//        if ($region) {
//            print_r($region);
//        }

//        $curl = curl_init();
//
//        curl_setopt_array($curl, array(
//            CURLOPT_URL => "https://api.mobra.in/v1/campaign/feed",
//            CURLOPT_RETURNTRANSFER => true,
//            CURLOPT_ENCODING => "",
//            CURLOPT_MAXREDIRS => 10,
//            CURLOPT_TIMEOUT => 30,
//            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
//            CURLOPT_CUSTOMREQUEST => "GET",
//            CURLOPT_POSTFIELDS => "",
//            CURLOPT_HTTPHEADER => array(
//                "cache-control: no-cache",
//                "cookie: mobrain_api=eyJpdiI6IjNxNWUyendWYlVBRFhWUDRrYjBFNWRHRGNEcU5EQlZ2UGxmTmZ6VDNCRU09IiwidmFsdWUiOiJoWUpsV294Z2ZOdStiYXhRWU0wdTIraWZPMzRXN2l0QkNNeXBrekNQeVQwYWFMWGpuWmNyajkzTUtWQ085NExiTW9OZVBvQjVQZVwvQVdBWGd2QUJMcWc9PSIsIm1hYyI6IjIyMDlkZjM1MjI4NjUwNDBmMDExZDUyZmExNzQxYzM4MTk4MDA3Mjk0MTY5M2FiMzY0YWFhYTdiYzA4NGY1NzEifQ%3D%3D"
//            ),
//        ));
//
//        $response = curl_exec($curl);
//        $err = curl_error($curl);
//
//        curl_close($curl);
//
//        if ($err) {
//            echo "cURL Error #:" . $err;
//        } else {
//            var_dump($response);
//        }

//        $curl = new Curl();
////        $re = $curl->post('http://api.mobra.in/v1/auth/login?user=boster@superads.cn&password=Mobrain123',false);
////        var_dump($curl->responseHeaders);
////        die();
//        $response = $curl->setOption(
//            CURLOPT_HTTPHEADER,
//            array(
//                "cache-control: no-cache",
//                "cookie: mobrain_api=eyJpdiI6InhEbk5xcmtcL3dPTHNOa3BVdTFjZjZaYVZvWmttNTdcL3hBRUlzVFdDV0c2WT0iLCJ2YWx1ZSI6Im1nV0pseVZPVGRkUDNjNkpOUTB4eitKUGNEY0gxT3FDRzgydm1HOTZXTVVnWDd3MWJXclpJNUlXZTN4MmhTMW4yQzdpK0FDR3VcL0x1bHdJXC9QTmNlcHc9PSIsIm1hYyI6IjAxMDg2ZmQ0YzNlYjhiZWViYjc2YzQ3NDg3MjRiYjE1MzI5Y2NiYjUyZGYxN2Q5OTdkYmY5NDA3ZTFjNTdlZjYifQ%3D%3D"
//            )
//        )
//            ->get('https://api.mobra.in/v1/campaign/feed');
//        var_dump($response);
        $url = "https://go4.mobrain.xyz/b19a58d?p={subID}&sid={click_id}&android_a_id={GAID}&idfa={IDFA}";
        $aa = substr($url,0,stripos($url,'?'));
        echo $aa.'\n';


    }

}