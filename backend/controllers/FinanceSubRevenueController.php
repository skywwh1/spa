<?php

namespace backend\controllers;

use backend\models\FinanceAdvertiserBillTerm;
use Yii;
use backend\models\FinanceSubRevenue;
use backend\models\FinanceSubRevenueSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;

/**
 * FinancesubRevenueController implements the CRUD actions for FinancesubRevenue model.
 */
class FinanceSubRevenueController extends Controller
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
     * Lists all FinanceSubRevenue models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FinanceSubRevenueSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FinancesubRevenue model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new FinancesubRevenue model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $bill_id
     * @return mixed
     */
    public function actionCreate($bill_id)
    {
        $model = new FinanceSubRevenue();
//        var_dump($bill_id);
//        die();

        $model->advertiser_bill_id = $bill_id;

        if ($model->load(Yii::$app->request->post())) {
            $this->beforeSave($model);
            if ($model->save()) {
                $this->asJson(['success' => 1]);
            } else {
                var_dump($model->getErrors());
            }
        } else {
            return $this->renderAjax('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FinancesubRevenue model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing FinancesubRevenue model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the FinancesubRevenue model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FinancesubRevenue the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FinancesubRevenue::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param FinancesubRevenue $model
     */
    private function beforeSave(&$model)
    {
        $billTerm = FinanceAdvertiserBillTerm::findOne(['bill_id' => $model->advertiser_bill_id]);
        if (!empty($billTerm)) {
            $model->advertiser_id = $billTerm->adv_id;
        }
    }

    public function actionValidate()
    {
        $model = new FinanceSubRevenue();
        $request = \Yii::$app->getRequest();
        if ($request->isPost && $model->load($request->post())) {
            $billTerm = FinanceAdvertiserBillTerm::findOne(['bill_id' => $model->advertiser_bill_id]);
            if (!empty($billTerm)) {
                $model->advertiser_id = $billTerm->adv_id;
            }
            $this->asJson(ActiveForm::validate($model));
        }
    }
}
