<?php
/**
 * Created by PhpStorm.
 * User: Iven.Wu
 * Date: 2017-02-10
 * Time: 10:59
 */

namespace console\controllers;


use console\models\ADMobGeek;
use console\models\Affle;
use console\models\Avazu;
use console\models\Boom;
use console\models\Clinkad;
use console\models\Glispa;
use console\models\HeadWay;
use console\models\IGAWorks;
use console\models\Mi;
use console\models\MiDirect;
use console\models\Mobair;
use console\models\Movista;
use console\models\Mundo;
use console\models\Nposting;
use console\models\Promo;
use console\models\Svg;
use console\models\Taptica;
use console\models\Yeahmobi;
use console\models\Yeahmobi2;
use console\models\BoomApp;
use yii\console\Controller;

class ApiController extends Controller
{

    public function actionGetCampaigns()
    {
        $headWay = new HeadWay();
        $headWay->getApiCampaign();

//        $vista = new Movista();
//        $vista->getApiCampaign();

//        $yeah = new Yeahmobi();
//        $yeah->getApiCampaign();

//        $yeah = new Glispa();
//        $yeah->getApiCampaign();

//        $yeah = new Mi();
//        $yeah->getApiCampaign();

//        $yeah = new MiDirect();
//        $yeah->getApiCampaign();

//        $yeah = new Yeahmobi2();
//        $yeah->getApiCampaign();

        $yeah = new Nposting();
        $yeah->getApiCampaign();

        $yeah = new Mundo();
        $yeah->getApiCampaign();

        $yeah = new Taptica();
        $yeah->getApiCampaign();

        $yeah = new Mobair();
        $yeah->getApiCampaign();

        $yeah = new Clinkad();
        $yeah->getApiCampaign();

        $yeah = new IGAWorks();
        $yeah->getApiCampaign();

        $yeah = new ADMobGeek();
        $yeah->getApiCampaign();

        $yeah = new BoomApp();
        $yeah->getApiCampaign();

        $yeah = new Boom();
        $yeah->getApiCampaign();

        $avazu = new Avazu();
        $avazu->getApiCampaign();

        $avazu = new Svg();
        $avazu->getApiCampaign();

//        $avazu = new Promo();
//        $avazu->getApiCampaign();
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

    public function actionGetNposting()
    {
        $yeah = new Nposting();
        $yeah->getApiCampaign();
    }

    public function actionGetMi()
    {
        $yeah = new Mi();
        $yeah->getApiCampaign();
    }

    public function actionGetMiDirect()
    {
        $yeah = new MiDirect();
        $yeah->getApiCampaign();
    }

    public function actionGetYeah2()
    {
        $yeah = new Yeahmobi2();
        $yeah->getApiCampaign();
    }

    public function actionGetMundo()
    {
        $yeah = new Mundo();
        $yeah->getApiCampaign();
    }
    public function actionGetAffle()
    {
        $yeah = new Affle();
        $yeah->getApiCampaign();
    }

    public function actionGetTaptica()
    {
        $yeah = new Taptica();
        $yeah->getApiCampaign();
    }

    public function actionGetMobair()
    {
        $yeah = new Mobair();
        $yeah->getApiCampaign();
    }

    public function actionGetClink()
    {
        $yeah = new Clinkad();
        $yeah->getApiCampaign();
    }

    public function actionGetIgaWorks()
    {
        $yeah = new IGAWorks();
        $yeah->getApiCampaign();
    }

    public function actionGetGeek()
    {
        $yeah = new ADMobGeek();
        $yeah->getApiCampaign();
    }

    public function actionGetBoomApp()
    {
        $yeah = new BoomApp();
        $yeah->getApiCampaign();
    }

    public function actionGetBoom(){
        $yeah = new Boom();
        $yeah->getApiCampaign();
    }

    public function actionGetAvazu(){
        $avazu = new Avazu();
        $avazu->getApiCampaign();
    }

    public function actionGetSvg(){
        $svg = new Svg();
        $svg->getApiCampaign();
    }

    public function actionGetPromo(){
        $avazu = new Promo();
        $avazu->getApiCampaign();
    }
}