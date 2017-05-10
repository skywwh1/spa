<?php

namespace backend\controllers;

use common\models\ChannelReportSearch;
use common\models\Deliver;
use common\models\ReportAdvSearch;
use common\models\ReportChannelSearch;
use common\models\ReportSearch;
use common\models\ReportSubChannelSearch;
use common\models\ReportSummaryHourlySearch;
use common\models\ReportSummarySearch;
use DateTime;
use DateTimeZone;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * ReportController implements the CRUD actions for Deliver model.
 */
class ReportController extends Controller
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => [
                            'index',
                            'report-channel',
                            'report-adv',
                            'report-summary',
                            'report-sub-channel',
                        ],
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
        /* $searchModel = new ReportSearch();
         $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

         return $this->render('index', [
             'searchModel' => $searchModel,
             'dataProvider' => $dataProvider,
         ]);*/
        $searchModel = new ReportSearch();
        $dataProvider = array();

        $searchModel->time_zone = 'Etc/GMT-8';
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone($searchModel->time_zone));
        $date->setTimestamp(time());
        $date->format('Y-m-d');
        $searchModel->start = $date->format('Y-m-d');
        $searchModel->end = $date->format('Y-m-d');
        $searchModel->type = 2;
//        $dataProvider = $searchModel->dailySearch(Yii::$app->request->queryParams);
        if (!empty(Yii::$app->request->queryParams)) {
            $searchModel->load(Yii::$app->request->queryParams);
            $type = $searchModel->type;
            if ($type == 1) {
                $dataProvider = $searchModel->hourlySearch(Yii::$app->request->queryParams);
            } else if ($type == 2) {
                $dataProvider = $searchModel->dailySearch(Yii::$app->request->queryParams);
            } else {
                $dataProvider = $searchModel->sumSearch(Yii::$app->request->queryParams);
            }
        }
        $summary = $searchModel->summarySearch(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'summary' => $summary,
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


    /**
     * Finds the Deliver model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $campaign_id
     * @param integer $channel_id
     * @return Deliver the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($campaign_id, $channel_id)
    {
        if (($model = Deliver::findOne(['campaign_id' => $campaign_id, 'channel_id' => $channel_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionReportChannel()
    {
        $searchModel = new ReportChannelSearch();

        $searchModel->time_zone = 'Etc/GMT-8';
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone($searchModel->time_zone));
        $date->setTimestamp(time());
        $date->format('Y-m-d');
        $searchModel->start = $date->format('Y-m-d');
        $searchModel->end = $date->format('Y-m-d');
        $searchModel->type = 2;
        $dataProvider = $dataProvider = $searchModel->dailySearch(Yii::$app->request->queryParams);
        if (!empty(Yii::$app->request->queryParams)) {
            $searchModel->load(Yii::$app->request->queryParams);
            $type = $searchModel->type;

            if ($type == 1) {
                $dataProvider = $searchModel->hourlySearch(Yii::$app->request->queryParams);
            } else if ($type == 2) {
                $dataProvider = $searchModel->dailySearch(Yii::$app->request->queryParams);
            } else {
                $dataProvider = $searchModel->sumSearch(Yii::$app->request->queryParams);
            }
        }
        $summary = $searchModel->summarySearch(Yii::$app->request->queryParams);
        return $this->render('report_channel', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'summary' => $summary,
        ]);
    }

    public function actionReportAdv()
    {
        $searchModel = new ReportAdvSearch();
        $searchModel->time_zone = 'Etc/GMT-8';
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone($searchModel->time_zone));
        $date->setTimestamp(time());
        $date->format('Y-m-d');
        $searchModel->start = $date->format('Y-m-d');
        $searchModel->end = $date->format('Y-m-d');
        $searchModel->type = 2;
//        $searchModel->bd = Yii::$app->user->id;
        $dataProvider = $searchModel->dailySearch(Yii::$app->request->queryParams);
        if (!empty(Yii::$app->request->queryParams)) {
            $searchModel->load(Yii::$app->request->queryParams);
            $type = $searchModel->type;
            if ($type == 1) {
                $dataProvider = $searchModel->hourlySearch(Yii::$app->request->queryParams);
            } else if ($type == 2) {
                $dataProvider = $searchModel->dailySearch(Yii::$app->request->queryParams);
            } else {
                $dataProvider = $searchModel->sumSearch(Yii::$app->request->queryParams);
            }
        }
        $summary = $searchModel->summarySearch(Yii::$app->request->queryParams);
        return $this->render('report_adv', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'summary' => $summary,
        ]);
    }

    public function actionReportSummary()
    {
        $searchModel = new ReportSummarySearch();
        $dataProvider = array();
        $summary = array();
        if (!empty(Yii::$app->request->queryParams)) {
            $searchModel->load(Yii::$app->request->queryParams);
            $type = $searchModel->type;
            if ($type == 1) {
                $dataProvider = $searchModel->hourlySearch(Yii::$app->request->queryParams);
            } else if ($type == 2) {
                $dataProvider = $searchModel->dailySearch(Yii::$app->request->queryParams);
            } else {
                $dataProvider = $searchModel->summarySearch(Yii::$app->request->queryParams);
            }
            $summary = $searchModel->summary(Yii::$app->request->queryParams);
        }

        return $this->render('report_summary', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'summary' => $summary,
        ]);
    }

    public function actionCampaign()
    {
//        return parent::actions(); // TODO: Change the autogenerated stub
    }

    public function actionReportSubChannel()
    {
        $searchModel = new ReportSubChannelSearch();
        $dataProvider = array();

        $searchModel->time_zone = 'Etc/GMT-8';
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone($searchModel->time_zone));
        $date->setTimestamp(time());
        $date->format('Y-m-d');
        $searchModel->start = $date->format('Y-m-d');
        $searchModel->end = $date->format('Y-m-d');
        $searchModel->type = 2;
//        $dataProvider = $searchModel->dailySearch(Yii::$app->request->queryParams);
        if (!empty(Yii::$app->request->queryParams)) {
            $searchModel->load(Yii::$app->request->queryParams);
            $type = $searchModel->type;

            if ($type == 1) {
                $dataProvider = $searchModel->hourlySearch(Yii::$app->request->queryParams);
            } else if ($type == 2) {
                $dataProvider = $searchModel->dailySearch(Yii::$app->request->queryParams);
            } else {
                $dataProvider = $searchModel->sumSearch(Yii::$app->request->queryParams);
            }
        }
        $summary = $searchModel->summarySearch(Yii::$app->request->queryParams);
        return $this->render('report_sub_channel', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'summary' => $summary,
        ]);
    }
}
