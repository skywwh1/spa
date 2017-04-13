<?php

namespace backend\controllers;

use Yii;
use backend\models\FinanceAdvertiserBillTerm;
use backend\models\FinanceAdvertiserBillTermSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FinanceAdvertiserBillTermController implements the CRUD actions for FinanceAdvertiserBillTerm model.
 */
class FinanceAdvertiserBillTermController extends Controller
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
     * Lists all FinanceAdvertiserBillMonth models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FinanceAdvertiserBillTermSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FinanceAdvertiserBillMonth model.
     * @param integer $adv_id
     * @param integer $start_time
     * @param integer $end_time
     * @return mixed
     */
    public function actionView($adv_id, $start_time, $end_time)
    {
        return $this->render('view', [
            'model' => $this->findModel($adv_id, $start_time, $end_time),
        ]);
    }

    /**
     * Creates a new FinanceAdvertiserBillMonth model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FinanceAdvertiserBillTerm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'adv_id' => $model->adv_id, 'start_time' => $model->start_time, 'end_time' => $model->end_time]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FinanceAdvertiserBillMonth model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $adv_id
     * @param integer $start_time
     * @param integer $end_time
     * @return mixed
     */
    public function actionUpdate($adv_id, $start_time, $end_time)
    {
        $model = $this->findModel($adv_id, $start_time, $end_time);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'adv_id' => $model->adv_id, 'start_time' => $model->start_time, 'end_time' => $model->end_time]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing FinanceAdvertiserBillMonth model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $adv_id
     * @param integer $start_time
     * @param integer $end_time
     * @return mixed
     */
    public function actionDelete($adv_id, $start_time, $end_time)
    {
        $this->findModel($adv_id, $start_time, $end_time)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the FinanceAdvertiserBillMonth model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $adv_id
     * @param integer $start_time
     * @param integer $end_time
     * @return FinanceAdvertiserBillTerm the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($adv_id, $start_time, $end_time)
    {
        if (($model = FinanceAdvertiserBillTerm::findOne(['adv_id' => $adv_id, 'start_time' => $start_time, 'end_time' => $end_time])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
