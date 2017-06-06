<?php

namespace backend\controllers;

use backend\models\FinanceAddRevenueSearch;
use backend\models\FinanceAdvertiserCampaignBillTermSearch;
use backend\models\FinanceAdvertiserPrepaymentSearch;
use backend\models\FinanceDeduction;
use backend\models\FinanceDeductionSearch;
use backend\models\FinancePendingSearch;
use backend\models\FinanceSubRevenueSearch;
use common\models\Advertiser;
use Yii;
use backend\models\FinanceAdvertiserBillTerm;
use backend\models\FinanceAdvertiserBillTermSearch;
use yii\helpers\Json;
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
        $advertiser = Advertiser::findOne($model->adv_id);

        if ($model->load(Yii::$app->request->post())) {
            switch ($model->status)
            {
                case 3:
                    $model->status = 1;
                    break;
                case 5:
                    $model->status = 1;
                    break;
                default:
                    $model->status = $model->status;
            }
            if ($model->save()) {
                $this->asJson(['success' => 1]);
            } else {
                var_dump($model->getErrors());
            }
        } else {

            //receivable
            $receivableModel = new FinanceAdvertiserBillTermSearch();
            $receivableModel->bill_id = $bill_id;
//            $receivableList = $receivableModel->search(Yii::$app->request->queryParams);
            $receivableList = $receivableModel->receivableSearch(Yii::$app->request->queryParams);
            //systemRevenue
            $systemRevenueModel = new FinanceAdvertiserCampaignBillTermSearch();
            $systemRevenueModel->bill_id = $bill_id;
            $systemRevenueList = $systemRevenueModel->search(Yii::$app->request->queryParams);

            // confirmed
            $confirmSearchModel = new FinancePendingSearch();
            $confirmSearchModel->status = 1;
            $confirmSearchModel->adv_bill_id_new = $bill_id;
            $confirmList = $confirmSearchModel->financePendingSearch(Yii::$app->request->queryParams);

            // pending
            $pendingSearchModel = new FinancePendingSearch();
            $pendingSearchModel->adv_bill_id = $bill_id;
            $pendingSearchModel->status = 0;
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

            //subRevenue
            $subRevenueModel = new FinanceSubRevenueSearch();
            $subRevenueModel->advertiser_bill_id = $bill_id;
            $subRevenueList = $subRevenueModel->search(Yii::$app->request->queryParams);

            return $this->render('update', [
                'receivableList' => $receivableList,
                'model' => $model,
                'advertiser' => $advertiser,
                'systemRevenueList' => $systemRevenueList,
                'confirmList' => $confirmList,
                'deductionList' => $deductionList,
                'pendingList' => $pendingList,
                'prepaymentList' => $prepaymentList,
                'addRevenueList' => $addRevenueList,
                'subRevenueList' => $subRevenueList,
                'searchModel' => $systemRevenueModel,
            ]); }
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

    /**
     * @param $bill_id
     * @param $status
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException
     */
    public function actionFlow($bill_id,$status)
    {
        $model = new FinanceAdvertiserBillTerm();
        $model->bill_id = $bill_id;

        $model = $this->findModel($bill_id);
        //BD Leader Reject and Finance Reject will set status = pending
        switch ($status)
        {
            case 3:
                $model->status = 1;
                break;
            case 5:
                $model->status = 1;
                break;
            default:
                $model->status = $status;
        }
        if ( $model->save()) {
            return $this->redirect(Yii::$app->request->referrer);
        } else {
            var_dump($model->getErrors());
        }
    }
}
