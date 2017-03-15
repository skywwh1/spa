<?php

namespace frontend\controllers;

use frontend\models\MyCampaignLogDailySearch;
use frontend\models\MyCampaignLogHourlySearch;
use frontend\models\MyCampaignLogSearch;
use Yii;
use common\models\Deliver;
use frontend\models\MyReportSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * MyReportController implements the CRUD actions for Deliver model.
 */
class MyReportController extends Controller
{
    public $layout = "my_main";

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['hourly', 'daily', 'offers'],
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
    public function actionIndex()
    {
        $searchModel = new MyReportSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Deliver models.
     * @return mixed
     */
    public function actionHourly()
    {
//        $searchModel = new MyReportSearch();
//        $dataProvider = $searchModel->hourlySearch(Yii::$app->request->queryParams);
//
//        return $this->render('hourly', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);
        $searchModel = new MyCampaignLogHourlySearch();
        $dataProvider = array();
        if (!empty(Yii::$app->request->queryParams)) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }

        return $this->render('hourly', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Deliver models.
     * @return mixed
     */
    public function actionDaily()
    {
        $searchModel = new MyCampaignLogDailySearch();
        $dataProvider = array();
        if (!empty(Yii::$app->request->queryParams)) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }

        return $this->render('daily', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionOffers()
    {
//        $searchModel = new MyReportSearch();
//        $dataProvider = $searchModel->offersSearch(Yii::$app->request->queryParams);
//
//        return $this->render('offers', [
//            'searchModel' => $searchModel,
//            'dataProvider' => $dataProvider,
//        ]);

        $searchModel = new MyCampaignLogSearch();
        $dataProvider = array();
        if (!empty(Yii::$app->request->queryParams)) {
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        }

        return $this->render('offers', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * Displays a single Deliver model.
     * @param integer $campaign_id
     * @param integer $channel_id
     * @return mixed
     */
    public function actionView($campaign_id, $channel_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($campaign_id, $channel_id),
        ]);
    }


    protected function findModel($campaign_id, $channel_id)
    {
        if (($model = Deliver::findOne(['campaign_id' => $campaign_id, 'channel_id' => $channel_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
