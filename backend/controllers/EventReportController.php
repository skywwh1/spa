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
        $searchModel->time_zone = 'Etc/GMT-8';

        $searchModel->load(Yii::$app->request->queryParams);
        $date = new DateTime();
        $date->setTimezone(new DateTimeZone($searchModel->time_zone));
        $date->setTimestamp(time());
        $date->format('Y-m-d');
        $searchModel->start = $date->format('Y-m-d');
        $searchModel->end = $date->format('Y-m-d');

        switch ($searchModel->type) {
            case 1:
                $dataProvider = $searchModel->SummarySearch(Yii::$app->request->queryParams);
                $dataProvider_column = $searchModel->dynamicSummarySearch(Yii::$app->request->queryParams);
                break;
            case 2:
                $dataProvider = $searchModel->dailySearch(Yii::$app->request->queryParams);
                $dataProvider_column = $searchModel->dynamicDailySearch(Yii::$app->request->queryParams);
                break;
            case 3:
                $dataProvider = $searchModel->subDailySearch(Yii::$app->request->queryParams);
                $dataProvider_column = $searchModel->subDynamicDailySearch(Yii::$app->request->queryParams);
                break;
            case 4:
                $dataProvider = $searchModel->subSummarySearch(Yii::$app->request->queryParams);
                $dataProvider_column = $searchModel->subDynamicSummarySearch(Yii::$app->request->queryParams);
                break;
            default:
                $dataProvider = $searchModel->dailySearch(Yii::$app->request->queryParams);
                $dataProvider_column = $searchModel->dynamicDailySearch(Yii::$app->request->queryParams);
                break;
        }

        $models = empty($dataProvider) ? null : $dataProvider->getModels();
        $columns = empty($dataProvider_column) ? null : $dataProvider_column->getModels();

        $cols = [];
        $dynamic_cols = [];
        $match_cols = [];
        if (!empty($models) && !(empty($columns))) {
            if ($searchModel->type == 3 || $searchModel->type == 4){
                foreach ($models as $model) {
                    $flag = 0;
                    foreach ($columns as $column) {
                        if ($model['campaign_id'] == $column->campaign_id
                            && $model['channel_id'] == $column->channel_id
                            && $model['sub_channel'] == $column->ch_subid
                            && array_key_exists('timestamp',$model)?$model['timestamp'] == $column->timestamp:true
                        ) {
                            $model['column_name'][$column->event] = $column->total;
                            $cols[$column->event] = $column->total;

                            $model['match_column'][$column->event] = $column->match_total;
                            $cols[$column->event] = $column->match_total;
                            $flag = 1;
                        }
                    }
                    if ($flag == 0){
                        $model['column_name']['none'] = 0;
                        $model['match_column']['none'] = 0;
                    }
                    if (!empty($model['column_name'])) {
                        $dynamic_cols[] = $model['column_name'];
                        $match_cols[] = $model['match_column'];
                    }
                }
            } else{
                foreach ($models as $model) {
                    $flag = 0;
                    foreach ($columns as $column) {
                        if ($model['campaign_id'] == $column->campaign_id
                            && $model['channel_id'] == $column->channel_id
                            && array_key_exists('timestamp',$model)?$model['timestamp'] == $column->timestamp:true
                        ) {
                            $model['column_name'][$column->event] = $column->total;
                            $cols[$column->event] = $column->total;

                            $model['match_column'][$column->event] = $column->match_total;
                            $cols[$column->event] = $column->match_total;
                            $flag = 1;
                        }
                    }
                    if ($flag == 0){
                        $model['column_name']['none'] = 0;
                        $model['match_column']['none'] = 0;
                    }
                    if (!empty($model['column_name'])) {
                        $dynamic_cols[] = $model['column_name'];
                        $match_cols[] = $model['match_column'];
                    }
                }
            }
        }
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'column_names' => $dynamic_cols,
            'match_cols' => $match_cols,
            'cols' => $cols,
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
