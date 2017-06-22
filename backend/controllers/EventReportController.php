<?php

namespace backend\controllers;

use DateTime;
use DateTimeZone;
use Yii;
use common\models\LogEventHourly;
use common\models\EventReportSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * EventReportController implements the CRUD actions for LogEventHourly model.
 */
class EventReportController extends Controller
{
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
        ];
    }

    /**
     * Lists all LogEventHourly models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new EventReportSearch();
//        $searchModel->time_zone = 'Etc/GMT-8';
//        $date = new DateTime();
//        $date->setTimezone(new DateTimeZone($searchModel->time_zone));
//        $date->setTimestamp(time());
//        $date->format('Y-m-d');
//        $searchModel->start = $date->format('Y-m-d');
//        $searchModel->end = $date->format('Y-m-d');
//        $searchModel->type = 2;
//        $dataProvider = $searchModel->dailySearch(Yii::$app->request->queryParams);
//        if (!empty(Yii::$app->request->queryParams)) {
//            $searchModel->load(Yii::$app->request->queryParams);
//            $type = $searchModel->type;
//
//            if ($type == 1) {
//                $dataProvider = $searchModel->hourlySearch(Yii::$app->request->queryParams);
//            } else if ($type == 2) {
//                $dataProvider = $searchModel->dailySearch(Yii::$app->request->queryParams);
//            } else {
//                $dataProvider = $searchModel->sumSearch(Yii::$app->request->queryParams);
//            }
//        }
//        $summary = $searchModel->summarySearch(Yii::$app->request->queryParams);
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
//            'summary' => $summary,
        ]);
    }

    /**
     * Displays a single LogEventHourly model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }


}
