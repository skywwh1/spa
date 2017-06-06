<?php

namespace backend\controllers;

use backend\models\FinancePendingForm;
use common\models\Advertiser;
use common\models\Campaign;
use common\models\CampaignLogHourly;
use common\models\Channel;
use common\models\Deliver;
use common\models\User;
use backend\models\FinanceChannelBillTerm;
use backend\models\FinanceAdvertiserBillTerm;
use DateInterval;
use DateTime;
use DateTimeZone;
use Yii;
use backend\models\FinancePending;
use backend\models\FinancePendingSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;
use yii\widgets\ActiveForm;

/**
 * FinancePendingController implements the CRUD actions for FinancePending model.
 */
class FinancePendingController extends Controller
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
                        'actions' => [
                            'index',
                            'update',
                            'add-adv',
                            'view',
                            'add-campaign',
                            'validate',
                            'add-adv-by-adv',
                            'update-pending'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all FinancePending models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new FinancePendingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single FinancePending model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->renderAjax('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new FinancePending model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new FinancePending();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new FinancePending model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddCampaign()
    {
        $model = new FinancePendingForm();
        if ($model->load(Yii::$app->request->post())) {
            if (isset($_POST['FinancePending']['is_all']) && $_POST['FinancePending']['is_all'] == 1) {
                $this->createMultipleByCam($model);
                return $this->redirect(['index']);
            } else {
                $model->channel_id = Channel::findByUsername($model->channel_name)->id;
                $this->savePending($model);
                return $this->redirect(['index']);
            }
        }else{
            return $this->render('campaign_pending_add', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Creates a new FinancePending model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddAdv()
    {
        $model = new FinancePendingForm();

        if ($model->load(Yii::$app->request->post())) {
            if (isset($_POST['FinancePending']['is_all']) && $_POST['FinancePending']['is_all'] == 1) {
                $this->createAdvToManyChannel($model);
                return $this->redirect(['index']);
            } else {
                $this->createAdvToOneChannel($model);
                return $this->redirect(['index']);
            }
        } else {
            return $this->render('adv_pending_add', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FinancePending model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->save()) {
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
     * Deletes an existing FinancePending model.
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
     * Finds the FinancePending model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return FinancePending the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = FinancePending::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param $model
     * @return string
     */
    private function savePending($model)
    {
        date_default_timezone_set('Etc/GMT-8');
        //type 1 是campaign pending
        $channel = Channel::findIdentity($model->channel_id);
        $cam = Campaign::findById($model->campaign_id);
//var_dump($model->channel_id);
//die();
        //加载report 数据；
        $channel_bill = $model->channel_id . '_' . date('Ym', strtotime($model->start_date));
        $adv_bill = (empty($cam->advertiser0))?null:$cam->advertiser0->id . '_' . date('Ym', strtotime($model->start_date));

        $start = strtotime($model->start_date);
        $end = strtotime($model->end_date) + 3600 * 24;

        $datas = FinancePending::findPendingByCamAndChannel( $model->campaign_id, $model->channel_id);
        $flag = true;
        foreach ($datas as $financePending){
            $flag = $this->compareTimeBetween($financePending,$start,strtotime($model->end_date));
            if(!$flag)
                break;
        }
        if(!$flag){
            return "you have add pending between ".$model->start_date." and ".$model->end_date." already!Please don't do it again!";
        }

        $records = CampaignLogHourly::findDateReport($start, $end, $model->campaign_id, $model->channel_id);
        if(!empty($records)){
            $pending = new FinancePending();
            $pending->channel_bill_id = $channel_bill;
            $pending->channel_id = $model->channel_id;
            $pending->campaign_id = $model->campaign_id;
            $pending->start_date = strtotime($model->start_date);
            $pending->end_date = strtotime($model->end_date);
            $pending->adv_bill_id = $adv_bill;
            $pending->installs = $records->installs;
            $pending->match_installs = $records->match_installs;
            $pending->cost = $records->cost;
            $pending->revenue = $records->revenue;
            $pending->margin = $pending->revenue == 0 ? 0 : ($pending->revenue - $pending->cost) / $pending->revenue;
            $pending->pm = empty(User::findIdentity($channel->pm)) ? null : User::findIdentity($channel->pm)->username;
            $pending->om = User::findIdentity($channel->om)->username;
            $pending->bd = User::findIdentity($cam->advertiser0->bd)->username;
            $pending->adv = $cam->advertiser0->username;
            $pending->adv_id = $cam->advertiser0->id;

            if (!$pending->save()) {
                var_dump($pending->getErrors());
                die();
            }
        }
    }

    private function createMultipleByCam($model)
    {
        $delivers = Deliver::findAllRunChannel($model->campaign_id);
        foreach ($delivers as $item) {
            $pending = new FinancePendingForm();
            $pending->campaign_id = $item->campaign_id;
            $pending->channel_id = $item->channel_id;
            $pending->start_date = $model->start_date;
            $pending->end_date = $model->end_date;
            $pending->note = $model->note;
            $this->savePending($pending);
        }
    }

    /**
     * @param $model
     * @return string
     */
    private function createAdvToOneChannel($model)
    {
        $advertiser = Advertiser::getOneByUsername($model->adv_name);
        $channel = Channel::findByUsername($model->channel_name);
        if (isset($advertiser) && isset($channel)) {
            $cams = $advertiser->campaigns;
            foreach ($cams as $item) {
                $pending = new FinancePendingForm();
                $pending->campaign_id = $item->id;
                $pending->channel_id = $channel->id;
                $pending->start_date = $model->start_date;
                $pending->end_date = $model->end_date;
                $pending->note = $model->note;
                $this->savePending($pending);
            }
        }
    }

    /**
     * @param FinancePendingForm $model
     */
    private function createAdvToManyChannel($model)
    {
//        var_dump($model->adv_name);
//        die();
        $advertiser = Advertiser::getOneByUsername($model->adv_name);
        if (isset($advertiser)) {

            $cams = $advertiser->campaigns;
            foreach ($cams as $item) {
                $model->campaign_id = $item->id;
                $this->createMultipleByCam($model);
            }
        }
    }

    public function actionValidate()
    {
        $model = new FinancePendingForm();
        $request = \Yii::$app->getRequest();
        if ($request->isPost && $model->load($request->post())) {
            if (empty($model->channel_id)) {
                $channel = Channel::findByUsername($model->channel_name);
                if (isset($channel)) {
                    $model->channel_id = $channel->id;
                }
            }
            $this->asJson(ActiveForm::validate($model));
        }
    }

    /**比较是否在时间范围内
     * @param $financePending
     * @param $start
     * @param $end
     * @return bool
     */
    private function compareTimeBetween($financePending,$start,$end){
        if (($financePending->start_date <= $start && $start <= $financePending->end_date)
            || ($financePending->start_date <= $end && $end <= $financePending->end_date))
            return false;
        return true;
    }

    /**
     * @param $adv_name
     * @param $period
     * @param $channel_name
     * @return string|Response
     */
    public function actionAddAdvByAdv($adv_name,$period,$channel_name)
    {
        $model = new FinancePendingForm();

        if ($model->load(Yii::$app->request->post())) {
            if (isset($_POST['FinancePending']['is_all']) && $_POST['FinancePending']['is_all'] == 1) {
                $this->createMultipleByCam($model);
                return $this->redirect(Yii::$app->request->referrer);
            } else {
                $this->createAdvToOneChannel($model);
                return $this->redirect(Yii::$app->request->referrer);
            }
        } else {
//            $model->campaign_id = $campaign_id;
            $model->adv_name = $adv_name;
            $model->channel_name = $channel_name;
            $model->start_date = str_replace(".","-",explode("-",$period)[0]);
            $model->end_date = str_replace(".","-",explode("-",$period)[1]);
            return $this->renderAjax('adv_pending_add', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing FinancePending model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdatePending($id)
    {
        $model = $this->findModel($id);
        $form = new FinancePendingForm();
        $form->start_date = date("Y-m-d",$model->start_date);
        $form->end_date =date("Y-m-d",$model->end_date);
        $form->adv_name = $model->adv;
        $form->channel_name = $model->channel->username;
        $form->note = $model->note;

        if ($model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($model->save()) {
                return ['success' => true];
            } else {
                var_dump($model->getErrors());
            }
        } else {
            return $this->renderAjax('adv_pending_update', [
                'model' => $form,
            ]);
        }
    }

}
