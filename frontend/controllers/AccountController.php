<?php

namespace frontend\controllers;

use common\models\Channel;
use common\models\ChannelUpdate;
use frontend\models\PaymentForm;
use frontend\models\ProfileForm;
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
        $old_attr = [];
        array_push($old_attr,$model->beneficiary_name,$model->bank_country,$model->bank_name,
            $model->bank_address,$model->swift,$model->account_nu_iban);

        if ( $model->load(Yii::$app->request->post()) && $model->update()) {
            $new_attr = [];
            array_push($new_attr,$model->beneficiary_name,$model->bank_country,$model->bank_name,
                $model->bank_address,$model->swift,$model->account_nu_iban);
            $diff = array_merge(array_diff($new_attr, $old_attr), array_diff($old_attr, $new_attr));
            if(count($diff)>0){
                $channel_update = new ChannelUpdate();
                $channel_update->channel_id = $model->channel_id;
                $channel_update->create_time = time();
                $channel_update->update_time = time();
                $channel_update->save();
            }
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
        $form->channel_id = $model->id;
        return $form;
    }

    public function actionReset()
    {

    }

    /**
     * Creates a new Channel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionProfile()
    {
        return $this->render('profile', [
            'model' => $this->findModel(Yii::$app->user->getId()),
        ]);
    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionUpdateProfile()
    {
        $model = $this->findProfileForm();
        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            return $this->redirect(['profile']);
        } else {
            return $this->render('profile_update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @return ProfileForm
     * @throws NotFoundHttpException
     */
    private function findProfileForm()
    {
        $model = $this->findModel(Yii::$app->user->getId());
        $form = new ProfileForm();
        $form->company = $model->company;
        $form->firstname = $model->firstname;
        $form->lastname = $model->lastname;
        $form->phone1 = $model->phone1;
        $form->skype = $model->skype;
        $form->email = $model->email;
        $form->company_address = $model->company_address;
        return $form;
    }

}
