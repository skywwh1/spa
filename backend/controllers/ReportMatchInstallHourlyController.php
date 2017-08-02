<?php

namespace backend\controllers;

use Yii;
use common\models\ReportMatchInstallHourly;
use common\models\ReportMatchInstallHourlySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReportMatchInstallHourlyController implements the CRUD actions for ReportMatchInstallHourly model.
 */
class ReportMatchInstallHourlyController extends Controller
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
     * Lists all ReportMatchInstallHourly models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReportMatchInstallHourlySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ReportMatchInstallHourly model.
     * @param integer $campaign_id
     * @param integer $time
     * @return mixed
     */
    public function actionView($campaign_id, $time)
    {
        return $this->render('view', [
            'model' => $this->findModel($campaign_id, $time),
        ]);
    }

    /**
     * Creates a new ReportMatchInstallHourly model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ReportMatchInstallHourly();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'campaign_id' => $model->campaign_id, 'time' => $model->time]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ReportMatchInstallHourly model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $campaign_id
     * @param integer $time
     * @return mixed
     */
    public function actionUpdate($campaign_id, $time)
    {
        $model = $this->findModel($campaign_id, $time);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'campaign_id' => $model->campaign_id, 'time' => $model->time]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ReportMatchInstallHourly model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $campaign_id
     * @param integer $time
     * @return mixed
     */
    public function actionDelete($campaign_id, $time)
    {
        $this->findModel($campaign_id, $time)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ReportMatchInstallHourly model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $campaign_id
     * @param integer $time
     * @return ReportMatchInstallHourly the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($campaign_id, $time)
    {
        if (($model = ReportMatchInstallHourly::findOne(['campaign_id' => $campaign_id, 'time' => $time])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
