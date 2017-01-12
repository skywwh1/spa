<?php
use yii\helpers\Json;

/**
 * Created by PhpStorm.
 * User: wh wu
 * Date: 1/10/2017
 * Time: 11:20 PM
 */
class JsonUtil
{

    public static function toTypeHeadJson($data){
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d];
        }
        return Json::encode($out);
    }
}