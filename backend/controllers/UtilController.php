<?php

namespace backend\controllers;

use common\models\Advertiser;
use common\models\Category;
use common\models\Channel;
use common\models\RegionsDomain;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\Response;

class UtilController extends Controller
{

    public function behaviors()
    {
        return [
            // ...
            'contentNegotiator' => [
                'class' => \yii\filters\ContentNegotiator::className(),
//                'only' => ['index', 'view'],
                'formatParam' => '_format',
                'formats' => [
                    'application/json' => Response::FORMAT_JSON,
//                    'application/xml' => \yii\web\Response::FORMAT_XML,
                ],
            ],
        ];
    }

    public function actionIndex()
    {
        $aa = new \stdClass();
        $aa->b = 00;
        return $aa;
    }

    public function actionDevice()
    {

    }

    public function actionGeo($name)
    {
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!$name) {
            return $out;
        }

        $data = RegionsDomain::find()
            ->select('domain id, domain text')
            ->andFilterWhere(['like', 'domain', $name])
            ->limit(50)
            ->asArray()
            ->all();

        $out['results'] = array_values($data);

        return $out;
    }

    public function actionCategory($name)
    {
        $out = ['results' => ['id' => '', 'text' => '']];
        if (!$name) {
            return $out;
        }

        $data = Category::find()
            ->select('name id, name text')
            ->andFilterWhere(['like', 'name', $name])
            ->limit(50)
            ->asArray()
            ->all();

        $out['results'] = array_values($data);

        return $out;
    }

    public function actionGetChannel($name)
    {
        $data = Channel::getChannelNameListByName($name);
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d];
        }
        return $out;
    }

    public function actionGetAdv($name)
    {
        $data = Advertiser::getAdvNameListByName($name);
        $out = [];
        foreach ($data as $d) {
            $out[] = ['value' => $d];
        }
        return $out;
    }
}
