<?php

namespace frontend\controllers;

use common\models\Channel;
use frontend\models\PaymentForm;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * AccountController implements the CRUD actions for Channel model.
 */
class AccountController extends Controller
{
    public $layout = 'my_main';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
        ];
    }


    /**
     * Creates a new Channel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionPayment()
    {
        return $this->render('payment', [
            'model' => $this->findModel(Yii::$app->user->getId()),
        ]);
    }

    /**
     * Updates an existing Channel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @internal param int $id
     */
    public function actionUpdate()
    {
        $model = $this->findPaymentForm();
        if ($model->load(Yii::$app->request->post()) && $model->update()) {

            return $this->redirect(['payment']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }


    /**
     * Finds the Channel model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Channel the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Channel::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @return PaymentForm
     */
    private function findPaymentForm()
    {
        $model = $this->findModel(Yii::$app->user->getId());
        $form = new PaymentForm();
        $form->payment_way = explode(',', $model->payment_way);
        $form->beneficiary_name = $model->beneficiary_name;
        $form->bank_country = $model->bank_country;
        $form->bank_name = $model->bank_name;
        $form->bank_address = $model->bank_address;
        $form->swift = $model->swift;
        $form->account_nu_iban = $model->account_nu_iban;
        return $form;
    }

    public function actionReset()
    {

    }

}
