<?php
/**
 * Created by PhpStorm.
 * User: Iven.Wu
 * Date: 2017-02-20
 * Time: 16:52
 */

namespace api\modules\v1\controllers;


use api\auth\QueryParamAuth;
use api\modules\v1\models\ChannelCampaign;
use common\models\Campaign;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use yii\rest\ActiveController;

class OfferController extends ActiveController
{
    public $modelClass = 'api\modules\v1\models\ChannelCampaign';

    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
            'tokenParam' => 'token',
        ];

        return $behaviors;
    }

    public function actions()
    {
        $actions = parent::actions();

        // disable the "delete" and "create" actions
        unset($actions['delete'], $actions['create']);

        // customize the data provider preparation with the "prepareDataProvider()" method
        $actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];

        return $actions;
    }

    //http://api.spa.com/v1/users?token=8bc5a37d14ebb5c7463dbb30f868f1d4&u=iven
    //&per-page=2&page=1
    public function prepareDataProvider()
    {
        // prepare and return a data provider for the "index" action
        $query = ChannelCampaign::find();
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
//                'defaultPageSize' => 100,
//                'pageSizeLimit' => false,
                'pageSizeParam' => 'page_size',
                'pageSizeLimit' => [1, 100],
            ],

        ]);
        $query->where(['channel_id' => \Yii::$app->user->getId()]);
        $query->orderBy('create_time DESC');
        return $dataProvider;
    }
}