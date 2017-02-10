<?php

namespace backend\controllers;

use Yii;
use common\models\ApiCampaign;
use common\models\ApiCampaignSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ApiCampaignController implements the CRUD actions for ApiCampaign model.
 */
class ApiCampaignController extends Controller
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
     * Lists all ApiCampaign models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ApiCampaignSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ApiCampaign model.
     * @param integer $adv_id
     * @param string $campaign_id
     * @return mixed
     */
    public function actionView($adv_id, $campaign_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($adv_id, $campaign_id),
        ]);
    }

    /**
     * Creates a new ApiCampaign model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ApiCampaign();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'adv_id' => $model->adv_id, 'campaign_id' => $model->campaign_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ApiCampaign model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $adv_id
     * @param string $campaign_id
     * @return mixed
     */
    public function actionUpdate($adv_id, $campaign_id)
    {
        $model = $this->findModel($adv_id, $campaign_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'adv_id' => $model->adv_id, 'campaign_id' => $model->campaign_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ApiCampaign model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $adv_id
     * @param string $campaign_id
     * @return mixed
     */
    public function actionDelete($adv_id, $campaign_id)
    {
        $this->findModel($adv_id, $campaign_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ApiCampaign model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $adv_id
     * @param string $campaign_id
     * @return ApiCampaign the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($adv_id, $campaign_id)
    {
        if (($model = ApiCampaign::findOne(['adv_id' => $adv_id, 'campaign_id' => $campaign_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
