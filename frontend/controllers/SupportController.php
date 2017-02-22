<?php

namespace frontend\controllers;

use api\modules\v1\models\Channel;
use common\models\Deliver;
use frontend\models\MyReportSearch;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * MyReportController implements the CRUD actions for Deliver model.
 */
class SupportController extends Controller
{
    public $layout = "my_main";

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [

            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['api'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Deliver models.
     * @return mixed
     */
    public function actionApi()
    {
        $model = Channel::findIdentity(Yii::$app->user->getId());
        return $this->render('index', ['model' => $model]);
    }

}
