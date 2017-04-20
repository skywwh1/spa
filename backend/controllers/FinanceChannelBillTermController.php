<?php

namespace backend\controllers;

use backend\models\FinanceAddCostSearch;
use backend\models\FinanceChannelPrepaymentSearch;
use backend\models\FinanceChannelCampaignBillTermSearch;
use backend\models\FinanceCompensationSearch;
use backend\models\FinanceDeduction;
use backend\models\FinanceDeductionSearch;
use backend\models\FinancePendingSearch;
use Yii;
use backend\models\FinanceChannelBillTerm;
use backend\models\FinanceChannelBillTermSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * FinanceChannelBillTermController implements the CRUD actions for FinanceChannelBillTerm model.
 */
class FinanceChannelBillTermController extends Controller
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
     * Lists all FinanceChannelBillTerm models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FinanceChannelBillTermSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FinanceChannelBillTerm model.
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
     * Creates a new FinanceChannelBillTerm model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FinanceChannelBillTerm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->bill_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FinanceChannelBillTerm model.
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
     * Deletes an existing FinanceChannelBillTerm model.
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
     * Finds the FinanceChannelBillTerm model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $id
     * @return FinanceChannelBillTerm the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FinanceChannelBillTerm::findOne($id)) !== null) {
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

            //payable
            $payableSearch = new FinanceChannelBillTermSearch();
            $payableSearch->bill_id = $bill_id;
            $payable = $payableSearch->search(Yii::$app->request->queryParams);

            //system cost
            $campaignBillSearchModel = new FinanceChannelCampaignBillTermSearch();
            $campaignBillSearchModel->bill_id = $bill_id;
            $campaignBill = $campaignBillSearchModel->search(Yii::$app->request->queryParams);

            // pending
            $pendingSearchModel = new FinancePendingSearch();
            $pendingSearchModel->channel_bill_id = $bill_id;
            $pendingList = $pendingSearchModel->search(Yii::$app->request->queryParams);

            // deduction
            $deductionSearchModel = new FinanceDeductionSearch();
            $deductionSearchModel->channel_bill_id = $bill_id;
            $deductionList = $deductionSearchModel->search(Yii::$app->request->queryParams);

            //compensation
            $compensationSearchModel = new FinanceCompensationSearch();
            $compensationSearchModel->deduction_ids = FinanceDeduction::getDeductionIds($bill_id);
            $compensationList = $compensationSearchModel->detailSearch(Yii::$app->request->queryParams);

            //prepayment
            $prepaymentSearch = new FinanceChannelPrepaymentSearch();
            $prepaymentSearch->channel_bill_id = $bill_id;
            $prepaymentList = $prepaymentSearch->search(Yii::$app->request->queryParams);

            //add cost list
            $costSearch = new FinanceAddCostSearch();
            $costSearch->channel_bill_id = $bill_id;
            $costList = $costSearch->search(Yii::$app->request->queryParams);


            return $this->render('update', [
                'payable' => $payable,
                'model' => $model,
                'campaignBill' => $campaignBill,
                'pendingList' => $pendingList,
                'deductionList' => $deductionList,
                'compensationList' => $compensationList,
                'prepaymentList' => $prepaymentList,
                'costList' => $costList,
            ]);
        }
    }

    public function actionRetreat($id)
    {
        $bill = FinanceChannelBillTerm::findOne($id);
        $bill->status = 1;
        if ($bill->save()) {
            $this->asJson(['success' => 1]);
        } else {
            var_dump($bill->getErrors());
        }
    }
}
