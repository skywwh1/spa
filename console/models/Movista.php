<?php

namespace console\models;

use common\models\AdvertiserApi;
use common\models\Campaign;
use linslin\yii2\curl\Curl;
use yii\db\BaseActiveRecord;

/**
 * Created by PhpStorm.
 * User: Iven.Wu
 * Date: 2017-02-27
 * Time: 10:21
 */
class Movista
{

    public function getApiCampaign()
    {
        $apis = AdvertiserApi::findOne(['id' => 4]);
        $data_key = $apis->json_offers_param;
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
        $response = json_decode($response);
        $data = $response->$data_key;
        if(isset($data)){

        }
//        var_dump($response);
//        die();
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
}