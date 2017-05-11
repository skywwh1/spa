<?php

namespace backend\controllers;
use common\models\Campaign;
use Yii;
use common\models\Advertiser;
use common\models\ChannelBlack;
use common\models\ChannelBlackSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use common\models\Channel;
use yii\filters\AccessControl;


/**
 * ChannelBlackController implements the CRUD actions for ChannelBlack model.
 */
class ChannelBlackController extends Controller
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
                            'view',
                            'index',
                            'create',
                            'update',
                            'delete',
                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Lists all ChannelBlack models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ChannelBlackSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ChannelBlack model.
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
     * Creates a new ChannelBlack model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ChannelBlack();
        $this->beforeUpdate($model);
        if ($model->load(Yii::$app->request->post())) {
            $this->beforeSave($model);
            $model->save();
            if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing ChannelBlack model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $this->beforeUpdate($model);
        if ($model->load(Yii::$app->request->post())) {
            $this->beforeSave($model);
            if ($model->save()) {
                return $this->redirect(['index']);
            }
        }else{
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing ChannelBlack model.
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
     * Finds the ChannelBlack model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ChannelBlack the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ChannelBlack::findOne($id)) !== null) {
            $adv = Advertiser::findOne($model->advertiser);
//            $camp = Campaign::findById($model->campaign_id);
            $channel = Channel::findOne($model->channel_id);

            $model->advertiser_name = $adv->username;
            $model->channel_name = $channel->username;
//            $model->campaign_name = $camp->campaign_name;
//            $model->campaign_uuid = $camp->campaign_uuid;
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * @param channelBlack $channelBlack
     */
    protected function beforeUpdate(&$channelBlack)
    {
        if (!empty($channelBlack->geo)) {
            $channelBlack->geo = explode(',', $channelBlack->geo);
        }
        if (!empty($channelBlack->os)) {
            $channelBlack->os = explode(',', $channelBlack->os);
        }
    }

    /**
     * @param channelBlack $model
     */
    protected function beforeSave(&$model)
    {
        $advertiser = Advertiser::getOneByUsername($model->advertiser);
        $model->advertiser = isset($advertiser) ? $advertiser->id : null;

        if (!empty($model->channel_name)) {
            $channel = Channel::findChannelByName($model->channel_name);
        }
        $model->channel_id = isset($channel) ? $channel->id : null;

//        if (!empty($model->campaign_uuid)) {
//            $campaign = Campaign::findByUuid($model->campaign_uuid);
//        }
//        $model->campaign_id = isset($campaign) ? $campaign->id : null;

        if (!empty($model->geo)) {
            $model->geo = implode(',', $model->geo);
        }
        if (!empty($model->os)) {
            $model->os = implode(',', $model->os);
        }
    }
}
