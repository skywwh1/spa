<?php

namespace backend\controllers;

use backend\models\FinanceChannelBillTerm;
use backend\models\FinanceDeduction;
use backend\models\FinancePendingForm;
use Yii;
use backend\models\FinanceCompensation;
use backend\models\FinanceCompensationSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * FinanceCompensationController implements the CRUD actions for FinanceCompensation model.
 */
class FinanceCompensationController extends Controller
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
     * Lists all FinanceCompensation models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FinanceCompensationSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FinanceCompensation model.
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
     * Creates a new FinanceCompensation model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param $deduction_id
     * @return mixed
     */
    public function actionCreate($deduction_id)
    {
        $model = FinanceCompensation::findOne($deduction_id);
        if (empty($model)) {
            $model = new FinanceCompensation();
            $model->deduction_id = $deduction_id;
        }
        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;

            $deduction = FinanceDeduction::findOne(['id' => $deduction_id]);
            if (!empty($deduction)) {
                $form = new FinancePendingForm();
                if(!$form->checkIsCheckedOut(null,$deduction->channel_bill_id)){
                    return  'cannot compensate to a closed bill';
                }
            }

            $this->beforeSave($model);
            if ($model->save()) {
                return ['success' => true];
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
     * Updates an existing FinanceCompensation model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $deduction = $model->deduction;
            $deduction->note = $model->note;

            if ($model->save() && $deduction->save()) {
                return ['success' => true];
            } else {
                var_dump($model->getErrors());
            }
        } else {
            return $this->renderAjax('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing FinanceCompensation model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;
        $status = false;
        if ($this->findModel($id)->delete()) {
            $status = true;
        }
        return ['success' => $status];
    }

    /**
     * Finds the FinanceCompensation model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FinanceCompensation the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FinanceCompensation::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    public function actionValidate()
    {
        $model = new FinanceCompensation();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = 'json';
            return ActiveForm::validate($model);
        }
    }

    /**
     * @param FinanceCompensation $model
     */
    private function beforeSave(&$model)
    {
        $model->billable_cost = ($model->deduction->cost) + ($model->deduction->deduction_cost) - ($model->compensation);

//        $model->billable_revenue =
    }
}
