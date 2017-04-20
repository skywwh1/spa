<?php

namespace backend\controllers;

use backend\models\FinanceAddRevenueSearch;
use backend\models\FinanceAdvertiserCampaignBillTermSearch;
use backend\models\FinanceAdvertiserPrepaymentSearch;
use backend\models\FinanceDeductionSearch;
use backend\models\FinancePendingSearch;
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
     * Lists all FinanceAdvertiserBillTerm models.
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
     * Displays a single FinanceAdvertiserBillTerm model.
     * @param string $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new FinanceAdvertiserBillTerm model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FinanceAdvertiserBillTerm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->bill_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FinanceAdvertiserBillTerm model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->bill_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing FinanceAdvertiserBillTerm model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the FinanceAdvertiserBillTerm model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return FinanceAdvertiserBillTerm the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FinanceAdvertiserBillTerm::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionEdit($bill_id)
    {
        $model = $this->findModel($bill_id);

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                $this->asJson(['success' => 1]);
            } else {
                var_dump($model->getErrors());
            }
        } else {

            //receivable
            $receivableModel = new FinanceAdvertiserBillTermSearch();
            $receivableModel->bill_id = $bill_id;
            $receivableList = $receivableModel->search(Yii::$app->request->queryParams);

            //systemRevenue
            $systemRevenueModel = new FinanceAdvertiserCampaignBillTermSearch();
            $systemRevenueList = $systemRevenueModel->search(Yii::$app->request->queryParams);

            // pending
            $pendingSearchModel = new FinancePendingSearch();
            $pendingSearchModel->adv_bill_id = $bill_id;
            $pendingList = $pendingSearchModel->search(Yii::$app->request->queryParams);

            //deduction
            $deductionSearchModel = new FinanceDeductionSearch();
            $deductionSearchModel->adv_bill_id = $bill_id;
            $deductionList = $deductionSearchModel->search(Yii::$app->request->queryParams);

            //prepayment
            $prepaymentSearch = new FinanceAdvertiserPrepaymentSearch();
            $prepaymentSearch->advertiser_bill_id = $bill_id;
            $prepaymentList = $prepaymentSearch->search(Yii::$app->request->queryParams);

            //addRevenue
            $addRevenueModel = new FinanceAddRevenueSearch();
            $addRevenueModel->advertiser_bill_id = $bill_id;
            $addRevenueList = $addRevenueModel->search(Yii::$app->request->queryParams);



            return $this->render('update', [
                'receivableList' => $receivableList,
                'model' => $model,
                'systemRevenueList' => $systemRevenueList,
                'deductionList' => $deductionList,
                'pendingList' => $pendingList,
                'prepaymentList' => $prepaymentList,
                'addRevenueList' => $addRevenueList,
            ]);
        }
    }

    public function actionRetreat($id)
    {
        $bill = FinanceAdvertiserBillTerm::findOne($id);
        $bill->status = 1;
        if ($bill->save()) {
            $this->asJson(['success' => 1]);
        } else {
            var_dump($bill->getErrors());
        }
    }
}
