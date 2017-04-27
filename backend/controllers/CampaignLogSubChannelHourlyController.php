<?php

namespace backend\controllers;

use Yii;
use common\models\CampaignLogSubChannelHourly;
use common\models\ReportSubChannelSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CampaignLogSubChannelHourlyController implements the CRUD actions for CampaignLogSubChannelHourly model.
 */
class CampaignLogSubChannelHourlyController extends Controller
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
     * Lists all CampaignLogSubChannelHourly models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ReportSubChannelSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CampaignLogSubChannelHourly model.
     * @param integer $campaign_id
     * @param integer $channel_id
     * @param string $sub_channel
     * @param integer $time
     * @return mixed
     */
    public function actionView($campaign_id, $channel_id, $sub_channel, $time)
    {
        return $this->render('view', [
            'model' => $this->findModel($campaign_id, $channel_id, $sub_channel, $time),
        ]);
    }

    /**
     * Creates a new CampaignLogSubChannelHourly model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CampaignLogSubChannelHourly();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'campaign_id' => $model->campaign_id, 'channel_id' => $model->channel_id, 'sub_channel' => $model->sub_channel, 'time' => $model->time]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing CampaignLogSubChannelHourly model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $campaign_id
     * @param integer $channel_id
     * @param string $sub_channel
     * @param integer $time
     * @return mixed
     */
    public function actionUpdate($campaign_id, $channel_id, $sub_channel, $time)
    {
        $model = $this->findModel($campaign_id, $channel_id, $sub_channel, $time);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'campaign_id' => $model->campaign_id, 'channel_id' => $model->channel_id, 'sub_channel' => $model->sub_channel, 'time' => $model->time]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing CampaignLogSubChannelHourly model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $campaign_id
     * @param integer $channel_id
     * @param string $sub_channel
     * @param integer $time
     * @return mixed
     */
    public function actionDelete($campaign_id, $channel_id, $sub_channel, $time)
    {
        $this->findModel($campaign_id, $channel_id, $sub_channel, $time)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the CampaignLogSubChannelHourly model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $campaign_id
     * @param integer $channel_id
     * @param string $sub_channel
     * @param integer $time
     * @return CampaignLogSubChannelHourly the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($campaign_id, $channel_id, $sub_channel, $time)
    {
        if (($model = CampaignLogSubChannelHourly::findOne(['campaign_id' => $campaign_id, 'channel_id' => $channel_id, 'sub_channel' => $sub_channel, 'time' => $time])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
