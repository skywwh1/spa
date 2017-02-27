<?php
/**
 * Created by PhpStorm.
 * User: Iven.Wu
 * Date: 2017-02-10
 * Time: 10:59
 */

namespace console\controllers;


use console\models\HeadWay;
use console\models\Movista;
use yii\console\Controller;

class ApiController extends Controller
{

    public function actionGetHeadway()
    {
        $headWay = new HeadWay();
        $headWay->getApiCampaign();

    }

    public function actionGetMovista()
    {
        $vista = new Movista();
        $vista->getApiCampaign();
    }
}