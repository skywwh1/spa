<?php
/**
 * Created by PhpStorm.
 * User: Iven.Wu
 * Date: 2017-02-10
 * Time: 10:59
 */

namespace console\controllers;


use common\models\Advertiser;
use common\models\AdvertiserApi;
use common\models\ApiCampaign;
use common\models\Campaign;
use common\models\Stream;
use common\utility\ApiUtil;
use linslin\yii2\curl\Curl;
use yii\console\Controller;
use yii\helpers\ArrayHelper;

class TestController extends Controller
{

    public function actionTest()
    {
        var_dump(Stream::getCountClicks());
    }
}