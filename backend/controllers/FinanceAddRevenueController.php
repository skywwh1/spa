<?php

namespace backend\controllers;

use backend\models\FinanceAdvertiserBillTerm;
use Yii;
use backend\models\FinanceAddRevenue;
use backend\models\FinanceAddRevenueSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;

/**
 * FinanceAddRevenueController implements the CRUD actions for FinanceAddRevenue model.
 */
class FinanceAddRevenueController extends Controller
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
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['view', 'index', 'create', 'update', 'delete', 'validate'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all FinanceAddRevenue models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FinanceAddRevenueSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FinanceAddRevenue model.
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
     * Creates a new FinanceAddRevenue model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $bill_id
     * @return mixed
     */
    public function actionCreate($bill_id)
    {
        $model = new FinanceAddRevenue();
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
     * Updates an existing FinanceAddRevenue model.
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
     * Deletes an existing FinanceAddRevenue model.
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
     * Finds the FinanceAddRevenue model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FinanceAddRevenue the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FinanceAddRevenue::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param FinanceAddRevenue $model
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
        $model = new FinanceAddRevenue();
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
