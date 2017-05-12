<?php

namespace backend\controllers;

use common\models\Campaign;
use common\models\CampaignSearch;
use common\models\Deliver;
use common\models\Stream;
use common\models\User;
use common\utility\MailUtil;
use linslin\yii2\curl\Curl;
use Symfony\Component\Yaml\Dumper;
use Yii;
use common\models\Channel;
use common\models\ChannelSearch;
use yii\base\DynamicModel;
use yii\base\Model;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ChannelController implements the CRUD actions for Channel model.
 */
class ChannelController extends Controller
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
                            'create',
                            'update',
                            'view',
                            'delete',
                            'applying',
                            'get_channel_name',
                            'get_om',
                            'view-applicant',
                            'my-channels',
                            'test',
                            'get_channel_multiple',
                            'om-edit',
                            'recommend',
                            'get-recommend',
                            'send-recommend'
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'roles' => ['admin'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all Channel models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ChannelSearch();
        $dataProvider = $searchModel->searchIndex(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Channel models.
     * @return mixed
     */
    public function actionMyChannels()
    {
        $searchModel = new ChannelSearch();
        $dataProvider = $searchModel->searchMyChannels(Yii::$app->request->queryParams);

        return $this->render('my_channels', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Channel models.
     * @return mixed
     */
    public function actionApplying()
    {
        $searchModel = new ChannelSearch();
        $dataProvider = $searchModel->searchApplying(Yii::$app->request->queryParams);

        return $this->render('applicants', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Channel model.
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
     * Creates a new Channel model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Channel();

        if ($model->load(Yii::$app->request->post())) {
            $this->beforeCreate($model);

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Channel model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $this->beforeUpdate($model);
        if ($model->load(Yii::$app->request->post())) {
            $this->beforeCreate($model);

            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        }
        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Channel model.
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

    public function actionGet_channel_name($name)
    {
        return \JsonUtil::toTypeHeadJson(Channel::getChannelNameListByName($name));
    }

    public function actionGet_om($om)
    {
        return \JsonUtil::toTypeHeadJson(User::getOMList($om));
    }

    public function actionViewApplicant($id)
    {
        $model = $this->findModel($id);
        return $this->render('applicant_view', [
            'model' => $model,
            'register' => $model->channelRegister,
        ]);
    }

    public function actionGet_channel_multiple($name)
    {
        return Channel::getChannelMultiple($name);
    }

    /**
     * @param Channel $model
     */
    protected function beforeCreate(&$model)
    {
        if (!empty($model->om)) {
            $user = User::findByUsername($model->om);
        }
        $model->om = isset($user) ? $user->id : null;
        if (!empty($model->master_channel)) {
            $main_chan = Channel::findChannelByName($model->master_channel);
        }
        $model->master_channel = isset($main_chan) ? $main_chan->id : null;
        if (!empty($model->payment_way)) {
            $model->payment_way = implode(',', $model->payment_way);
        }
        if (!empty($model->traffic_source)) {
            $model->traffic_source = implode(',', $model->traffic_source);
        }
        if (!empty($model->os)) {
            $model->os = implode(',', $model->os);
        }

        if (!empty($model->strong_geo)) {
            $model->strong_geo = implode(',', $model->strong_geo);
        }

        if (!empty($model->strong_category)) {
            $model->strong_category = implode(',', $model->strong_category);
        }
    }

    /**
     * @param Channel $model
     */
    protected function beforeUpdate(&$model)
    {
        if (!empty($model->payment_way)) {
            $model->payment_way = explode(',', $model->payment_way);
        }

        if (!empty($model->traffic_source)) {
            $model->traffic_source = explode(',', $model->traffic_source);
        }

        if (!empty($model->strong_geo)) {
            $model->strong_geo = explode(',', $model->strong_geo);
        }

        if (!empty($model->strong_category)) {
            $model->strong_category = explode(',', $model->strong_category);
        }
    }

///*****************************************************************************************
    public function actionTest()
    {

        $this->asJson(['aa' => 99]);
    }

    public function actionAjaxtest()
    {
        $data = "TTT";
        return $data;
    }

    public function actionTestpage($uuid = null)
    {
        echo Campaign::getCampaignsByUuid($uuid);
    }

    public function actionOmEdit($id)
    {
        $channel = new Channel();
        $request = Yii::$app->request;

        if ($request->isAjax && $request->post()) {
            $model = Channel::findOne($id);
            $model->om = Yii::$app->user->id;
            $model->save();
            return "success";
        } else {
            return "failed";
        }

    }

    public function actionRecommend($id)
    {
        $channel = $this->findModel($id);
        $campaignSearch = new CampaignSearch();
        $campaignSearch->platform = $channel->os;
        $campaignSearch->category = $channel->strong_category;
        $campaignSearch->target_geo = $channel->strong_geo;
        $dataProvider = $campaignSearch->recommendSearch(Yii::$app->request->queryParams);
        return $this->render('recommend', [
            'searchModel' => $campaignSearch,
            'dataProvider' => $dataProvider,
            'channel_id' => $id,
        ]);
    }

    public function actionGetRecommend($id, $cams)
    {
//        var_dump($cams);
//        die();
        $channel = $this->findModel($id);
        $campaignSearch = new CampaignSearch();
        $campaignSearch->campaign_name = explode(',', $cams);
        $dataProvider = $campaignSearch->recommendList(Yii::$app->request->queryParams);
        return $this->renderAjax('get-recommend', [
            'dataProvider' => $dataProvider,
            'cams' => $cams,
            'channel' => $channel,
        ]);
    }

    public function actionSendRecommend($id, $cams)
    {
        $channel = $this->findModel($id);
        $campaign_id = explode(',', $cams);

        $campaigns = Campaign::find()->where(['id' => $campaign_id])->all();
        if(MailUtil::sendGoodOffers($campaigns,$channel)){
            $this->asJson("send email success!");
        }else{
            $this->asJson("send email fail!");
        }
    }

}
