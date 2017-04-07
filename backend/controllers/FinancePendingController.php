<?php

namespace backend\controllers;

use common\models\Advertiser;
use common\models\Campaign;
use common\models\CampaignLogHourly;
use common\models\Channel;
use common\models\Deliver;
use common\models\User;
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
        return $this->render('view', [
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
        $model = new FinancePending();

        if ($model->load(Yii::$app->request->post())) {

            if (isset($model->is_all) && $model->is_all == 1) {
                $this->createMultipleByCam($model);
                return $this->redirect(['index']);
            } else {
                //加载channel_id;
                $channel = Channel::findOne(['username' => $model->channel_name]);
                if (!empty($model->channel_name)) {
                    if (!empty($channel)) {
                        $model->channel_id = $channel->id;
                    }
                }
                $this->savePending($model);
                return $this->redirect(['index']);
            }
        } else {
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
        $model = new FinancePending();

        if ($model->load(Yii::$app->request->post())) {

            if (isset($model->is_all) && $model->is_all == 1) {

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

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
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
     * @param FinancePending $model
     */
    private function savePending(&$model)
    {
        //加载channel_id;
        $channel = Channel::findIdentity($model->channel_id);
        $cam = Campaign::findById($model->campaign_id);
        //加载report 数据；
        $start = new DateTime($model->start_date, new DateTimeZone('Etc/GMT-8'));
        $end = new DateTime($model->end_date, new DateTimeZone('Etc/GMT-8'));
        $model->start_date = $start->getTimestamp();
        $model->end_date = $end->getTimestamp();
        $end = $end->add(new DateInterval('P1D'));
        $start = $start->getTimestamp();
        $end = $end->getTimestamp();
//        var_dump($start);
//        var_dump($end);
//        var_dump($model->campaign_id);
//        var_dump($model->channel_name);
//        die();
        $records = CampaignLogHourly::findDateReport($start, $end, $model->campaign_id, $model->channel_id);
        if (isset($records)) {
            $model->installs = $records->installs;
            $model->match_installs = $records->match_installs;
            $model->cost = $records->cost;
            $model->revenue = $records->revenue;
            $model->margin = $model->revenue == 0 ? 0 : ($model->revenue - $model->cost) / $model->revenue;
            $model->pm = empty(User::findIdentity($channel->pm)) ? null : User::findIdentity($channel->pm)->username;
            $model->om = User::findIdentity($channel->om)->username;
            $model->bd = User::findIdentity($cam->advertiser0->bd)->username;
            $model->adv = $cam->advertiser0->username;
            $model->save();
//            var_dump($model->getErrors());
//            die();
        } else {
            $model = null;
        }
    }

    private function createMultipleByCam($model)
    {
        $delivers = Deliver::findAllRunChannel($model->campaign_id);
//        var_dump($delivers);
//        die();
        foreach ($delivers as $item) {
            $pending = new FinancePending();
            $pending->campaign_id = $item->campaign_id;
            $pending->channel_id = $item->channel_id;
            $pending->start_date = $model->start_date;
            $pending->end_date = $model->end_date;
            $pending->note = $model->note;
            $this->savePending($pending);
        }
    }

    /**
     * @param FinancePending $model
     */
    private function createAdvToOneChannel($model)
    {
        $advertiser = Advertiser::getOneByUsername($model->adv_name);
        $channel = Channel::findByUsername($model->channel_name);
        if (isset($advertiser) && isset($channel)) {
            $cams = $advertiser->campaigns;
            foreach ($cams as $item) {
                $pending = new FinancePending();
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
     * @param FinancePending $model
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
}