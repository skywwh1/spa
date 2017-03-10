<?php
/**
 * Created by PhpStorm.
 * User: Iven.Wu
 * Date: 2017-02-10
 * Time: 10:59
 */

namespace console\controllers;


use console\models\Glispa;
use console\models\HeadWay;
use console\models\Movista;
use console\models\Yeahmobi;
use yii\console\Controller;

class ApiController extends Controller
{

    public function actionGetCampaigns()
    {
        $headWay = new HeadWay();
        $headWay->getApiCampaign();

        $vista = new Movista();
        $vista->getApiCampaign();

        $yeah = new Yeahmobi();
        $yeah->getApiCampaign();
    }

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

    public function actionGetYeah()
    {
        $yeah = new Yeahmobi();
        $yeah->getApiCampaign();
    }

    public function actionGetGlispa()
    {
        $yeah = new Glispa();
        $yeah->getApiCampaign();
    }
}