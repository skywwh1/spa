<?php

namespace backend\controllers;

use common\models\Deliver;
use Yii;
use common\models\ApplyCampaign;
use common\models\ApplyCampaignSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ApplyCampaignController implements the CRUD actions for ApplyCampaign model.
 */
class ApplyCampaignController extends Controller
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
                        'actions' => ['view',
                            'index',
                            'create',
                            'update',
                            'delete',
                            'deliver-create',
                            'reject',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all ApplyCampaign models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ApplyCampaignSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ApplyCampaign model.
     * @param integer $campaign_id
     * @param integer $channel_id
     * @return mixed
     */
    public function actionView($campaign_id, $channel_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($campaign_id, $channel_id),
        ]);
    }

    /**
     * Creates a new ApplyCampaign model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ApplyCampaign();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'campaign_id' => $model->campaign_id, 'channel_id' => $model->channel_id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ApplyCampaign model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $campaign_id
     * @param integer $channel_id
     * @return mixed
     */
    public function actionUpdate($campaign_id, $channel_id)
    {
        $model = $this->findModel($campaign_id, $channel_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'campaign_id' => $model->campaign_id, 'channel_id' => $model->channel_id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ApplyCampaign model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $campaign_id
     * @param integer $channel_id
     * @return mixed
     */
    public function actionDelete($campaign_id, $channel_id)
    {
        $this->findModel($campaign_id, $channel_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the ApplyCampaign model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $campaign_id
     * @param integer $channel_id
     * @return ApplyCampaign the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($campaign_id, $channel_id)
    {
        if (($model = ApplyCampaign::findOne(['campaign_id' => $campaign_id, 'channel_id' => $channel_id])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $campaign_id
     * @param integer $channel_id
     * @return mixed
     */
    public function actionReject($campaign_id, $channel_id)
    {
        if (Yii::$app->request->isAjax) {
            $model = $this->findModel($campaign_id, $channel_id);
            $model->status = 3;
            if($model->save()){
                return 'success';
            }
//            return $campaign_id.$channel_id;
        }

    }

    public function actionDeliverCreate($campaign_id, $channel_id)
    {
        $deliver = new Deliver();
        $request = Yii::$app->request;
        if ($request->isAjax && $request->post()) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $deliver->load($request->post());
            if ($deliver->save()) {
                $model = $this->findModel($deliver->campaign_id, $deliver->channel_id);
                $model->status = 2;
                $model->save();
                return "success";
            } else {
                return $deliver->getErrors();
            }

        } else {
            $deliver->campaign_id = $campaign_id;
            $deliver->channel_id = $channel_id;
            $deliver->campaign_uuid = isset($deliver->campaign) ? $deliver->campaign->campaign_uuid : "";
            $deliver->channel0 = isset($deliver->channel) ? $deliver->channel->username : '';
            $deliver->adv_price = isset($deliver->campaign) ? $deliver->campaign->adv_price : 0;
            $deliver->pay_out = isset($deliver->campaign) ? $deliver->campaign->now_payout : 0;
            $deliver->daily_cap = isset($deliver->campaign) ? $deliver->campaign->daily_cap : 0;
            $deliver->note = isset($deliver->campaign) ? $deliver->campaign->note : '';
            return $this->renderAjax('deliver_create', [
                'model' => $deliver,
            ]);
        }

    }
}
