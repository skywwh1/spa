<?php

namespace backend\controllers;

use backend\models\FinanceChannelBillTerm;
use Yii;
use backend\models\FinanceAddCost;
use backend\models\FinanceAddCostSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\widgets\ActiveForm;

/**
 * FinanceAddCostController implements the CRUD actions for FinanceAddCost model.
 */
class FinanceAddCostController extends Controller
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
     * Lists all FinanceAddCost models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FinanceAddCostSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FinanceAddCost model.
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
     * @param $bill_id
     * @return string
     */
    public function actionCreate($bill_id)
    {
        $model = new FinanceAddCost();
        $model->channel_bill_id = $bill_id;

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
     * Updates an existing FinanceAddCost model.
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
     * Deletes an existing FinanceAddCost model.
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
     * Finds the FinanceAddCost model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FinanceAddCost the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FinanceAddCost::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param FinanceAddCost $model
     */
    private function beforeSave(&$model)
    {
        $billTerm = FinanceChannelBillTerm::findOne(['bill_id' => $model->channel_bill_id]);
        if (!empty($billTerm)) {
            $model->channel_id = $billTerm->channel_id;
        }
    }

    public function actionValidate()
    {
        $model = new FinanceAddCost();
        $request = \Yii::$app->getRequest();
        if ($request->isPost && $model->load($request->post())) {
            $billTerm = FinanceChannelBillTerm::findOne(['bill_id' => $model->channel_bill_id]);
            if (!empty($billTerm)) {
                $model->channel_id = $billTerm->channel_id;
            }
            $this->asJson(ActiveForm::validate($model));
        }
    }
}
