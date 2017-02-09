<?php

namespace backend\controllers;

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

}
