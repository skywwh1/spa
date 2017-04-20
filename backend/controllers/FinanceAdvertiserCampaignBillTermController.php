<?php

namespace backend\controllers;

use Yii;
use backend\models\FinanceAdvertiserCampaignBillTerm;
use backend\models\FinanceAdvertiserCampaignBillTermSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FinanceAdvertiserCampaignBillTermController implements the CRUD actions for FinanceAdvertiserCampaignBillTerm model.
 */
class FinanceAdvertiserCampaignBillTermController extends Controller
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
     * Lists all FinanceAdvertiserCampaignBillTerm models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FinanceAdvertiserCampaignBillTermSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FinanceAdvertiserCampaignBillTerm model.
     * @param string $bill_id
     * @param integer $campaign_id
     * @return mixed
     */
    public function actionView($bill_id, $campaign_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($bill_id, $campaign_id),
        ]);
    }

    /**
     * Creates a new FinanceAdvertiserCampaignBillTerm model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FinanceAdvertiserCampaignBillTerm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'bill_id' => $model->bill_id, 'campaign_id' => $model->campaign_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FinanceAdvertiserCampaignBillTerm model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $bill_id
     * @param integer $campaign_id
     * @return mixed
     */
    public function actionUpdate($bill_id, $campaign_id)
    {
        $model = $this->findModel($bill_id, $campaign_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'bill_id' => $model->bill_id, 'campaign_id' => $model->campaign_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing FinanceAdvertiserCampaignBillTerm model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $bill_id
     * @param integer $campaign_id
     * @return mixed
     */
    public function actionDelete($bill_id, $campaign_id)
    {
        $this->findModel($bill_id, $campaign_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the FinanceAdvertiserCampaignBillTerm model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $bill_id
     * @param integer $campaign_id
     * @return FinanceAdvertiserCampaignBillTerm the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($bill_id, $campaign_id)
    {
        if (($model = FinanceAdvertiserCampaignBillTerm::findOne(['bill_id' => $bill_id, 'campaign_id' => $campaign_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
