<?php

namespace backend\controllers;

use common\models\Campaign;
use Yii;
use common\models\MyCart;
use common\models\MyCartSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\utility\MailUtil;
use common\models\Channel;

/**
 * MyCartController implements the CRUD actions for MyCart model.
 */
class MyCartController extends Controller
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
                        'actions' => ['index',
                            'create',
                            'update',
                            'view',
                            'delete',
                            'add-my-cart',
                            'selected',
                            'cancel',
                            'batch-delete',
                            'export-email',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all MyCart models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MyCartSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MyCart model.
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
     * Creates a new MyCart model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MyCart();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MyCart model.
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
     * Deletes an existing MyCart model.
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
     * Finds the MyCart model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MyCart the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MyCart::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Updates an existing Campaign model.
     * If insert is successful, the browser will be returned the success msg.
     * @param integer $campaign_id
     * @return mixed
     */
    public function actionAddMyCart($campaign_id)
    {
        $model = Campaign::findOne($campaign_id);

        $my_cart = MyCart::find()->where(['campaign_id' => $campaign_id])->one();
        if (!empty($my_cart)) {
            return 'you have added to my cart already!';
        }
        $my_cart = new Mycart();
        $my_cart->target_geo = $model->target_geo;
        $my_cart->advertiser = $model->advertiser;
        $my_cart->campaign_id = $model->id;
        $my_cart->campaign_name = $model->campaign_name;
        $my_cart->daily_cap = $model->daily_cap;
        $my_cart->direct = $model->direct;
        $my_cart->payout = $model->now_payout;
        $my_cart->platform = $model->platform;
        $my_cart->tag = $model->tag;
        $my_cart->traffic_source = $model->traffic_source;
        $my_cart->preview_link = $model->preview_link;

        if ($my_cart->save()) {
            return 'add to my cart success!';
        } else {
            return 'add to my cart fail!';
        }
    }

    /**
     * Select  MyCart columns.
     * @return mixed
     */
    public function actionSelected()
    {
        if (isset($_POST['keylist'])) {
//            $keys = \yii\helpers\Json::decode($_POST['keylist']);
            $keys = $_POST['keylist'];
        }
        $searchModel = new MyCartSearch();
        $dataProvider = $searchModel->showSelectCampaign($keys);

        return $this->renderAjax('detail', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'keys' => $keys,
        ]);
    }

    /**
     * Cancel an existing MyCart model.
     * If action is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionCancel()
    {
        return $this->redirect(['index']);
    }

    /**
     * Batch Deletes an existing MyCart model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionBatchDelete()
    {
        if (isset($_POST['keylist'])) {
            $keys = $_POST['keylist'];
        }

        foreach ($keys as $id){
            $this->findModel($id)->delete();
        }

        return $this->redirect(['index']);
    }

    public function actionExportEmail(){
        if (isset($_POST['keylist'])) {
            $keys = $_POST['keylist'];
        }
//        $my_carts = MyCart::find()->where(['id' => $keys])->all();
        $user_name = yii::$app->user->identity->username;
        $channel = Channel::findByUsername($user_name);
        $campaigns = Campaign::find()->where(['id' => $keys])->all();
        if(MailUtil::sendGoodOffers($campaigns,$channel)){
            $this->asJson("send email success!");
        }else{
            $this->asJson("send email fail!");
        }
    }
}
