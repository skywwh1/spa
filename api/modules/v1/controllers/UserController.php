<?php
/**
 * Created by PhpStorm.
 * User: Iven.Wu
 * Date: 2017-02-20
 * Time: 16:52
 */

namespace api\modules\v1\controllers;


use common\models\Campaign;
use yii\data\ActiveDataProvider;
use yii\filters\auth\HttpBearerAuth;
use yii\filters\auth\QueryParamAuth;
use yii\rest\ActiveController;

class UserController extends ActiveController
{
    public $modelClass = 'common\models\Campaign';

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
//        $actions = parent::actions();
//        $actions['index']['prepareDataProvider'] = function ($action) {
//            return new \yii\data\ActiveDataProvider([
//                'query' => Campaign::find()->where(['id' => 2]),
//            ]);
//        };

        $actions = parent::actions();
        unset($actions['index']);
        return $actions;
    }


    public function actionIndex()
    {
        $query = Campaign::find()->with('advertiser0');
        //$query = Country::find();

        return new ActiveDataProvider([
            'query' => $query,
        ]);
    }
}